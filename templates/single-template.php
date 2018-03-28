<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Customize Product</title>
<?php get_header(); ?>
</head>
<body>

<?php
  $categories = wp_get_post_terms($post->ID, 'template-category', array("fields" => "names"));
  $categories = array_reverse($categories);

  // get product category id from template category name
  $template_cat = $categories[1]; //child category
  $category = get_term_by( 'slug', $template_cat, 'product_cat' );
  $cat_id = $category->term_id;

  $base_price = get_post_meta($post ->ID, 'base_price',true);

  // CHECK IF USER IS EITHER ADMIN OR VENDOR
  $user = wp_get_current_user();
  if(!in_array( 'administrator', (array) $user->roles ) && !in_array( 'wc_product_vendors_admin_vendor', (array) $user->roles )){
    echo "<h1>Please sign in or register as a vendor</h1>";
  } else {

    // GET VENDOR ID
    $author_id = get_current_user_id();
    global $wpdb;
    $vendor_id = $wpdb->get_var( "SELECT term_id FROM wp_termmeta WHERE meta_key = 'vendor_data' AND meta_value LIKE '%i:$author_id;%'" );
    $vendor_name = $wpdb->get_var( "SELECT name FROM wp_terms WHERE term_id = '$vendor_id'" );
    $vendor_url = $wpdb->get_var( "SELECT slug FROM wp_terms WHERE term_id = '$vendor_id'" );
?>

<h1>Customize Product</h1>


<?php
if(sizeof($_GET) === 0){

echo do_shortcode("[fpd]");
echo do_shortcode("[fpd_form]");

?>

<div class="mt-5 d-flex">
  <h3 id="original-base-price" class="font-weight-bold mr-5">Base Price: $<?php echo $base_price; ?></h3>
  <h3 id="profit" class="font-weight-bold mr-5">Profit: $0</h3>
  <h3 class="font-weight-bold mr-5">Category: <?php echo implode(" > ",$categories); ?> </h3>
</div>

<!-- ///////////////////////////////// WHEN SEND FORM/////////////////////////////////// -->
<?php
}
//CREATE NEW PRODUCT
  if(sizeof($_GET) != 0){

    // print_r($_GET);

    // check if product url is empty
    $slug;
    if(!empty($_GET['product-url'])){
      $slug = $_GET['product-url'];
    }else{
      $slug = $_GET['product-name'];
    }

    //get image from image folder
    $time = date('Y/m/d');
    $image = $_GET['product-image'];
    $image = str_replace(" ","", $image);
    $image = str_replace("-","", $image);
    $image = str_replace("(","", $image);
    $image = str_replace(")","", $image);
    $image = str_replace("+","", $image);
    $image_folder = get_home_url()."/wp-content/uploads/fancy_products_uploads/$time/$image" ;
    // echo $image_folder;

    // info to add to product
    $data = [

        'name' => $_GET['product-name'],
        'description' => $_GET['product-description'],
        'regular_price' => $_GET['your-price'],
        'slug' => $slug,
        'status' => 'pending',
        'images' => [
            [
                'src' => $image_folder,
                'position' => 0
            ]
          ],
          'categories' => [
            [
                'id' => $cat_id
            ]
          ]
        // 'sale_price'  => '8'

    ];
    $request = new WP_REST_Request( 'POST' );
    $request->set_body_params( $data );
    $products_controller = new WC_REST_Products_Controller;
    $response = $products_controller->create_item( $request );

    // get the product id from response
    $response_string = print_r($response, true);
    $id_pos = strpos($response_string, '[id] =>');
    $id = substr($response_string, $id_pos);
    $name_pos = strpos($id, '[name] =>');
    $id = substr($id, 0, $name_pos);
    $id = str_replace('[id] =>','',$id);

    // echo 'current product : ' . $id;
    $author_id = get_current_user_id();


    // Access the database via SQL and use author id to get vendor id
    global $wpdb;
    $vendor_id = $wpdb->get_var( "SELECT term_id FROM wp_termmeta WHERE meta_key = 'vendor_data' AND meta_value LIKE '%i:$author_id;%'" );
    $wpdb->query( "INSERT INTO wp_term_relationships(object_id, term_taxonomy_id, term_order) VALUES($id, $vendor_id, 0)" );

    if(empty($image)){
      echo '<h4 class="mb-5 font-weight-bold">Please add images to the product</h4>';
    }else{
      echo '<h4 class="mb-5 font-weight-bold">Your product is now in review.</h4>';

    }
    ?>



<?php
  } else {
?>

<!-- //////////////////////////////// MCJ FORM//////////////////////////////////// -->

<div class="mt-4 mb-5" method="post">
  <form id="mcj-form" class=" text-center" onSubmit="imageLink();">

      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">$</div>
        </div>
        <input type="number" class="form-control" id="your-price" name="your-price"  min="<?php echo $base_price; ?>" step="0.01" max="2500" placeholder="Your Price" required="required">
      </div>

    <div class="form-group">
      <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Product Name" required="required">
    </div>

    <div class="form-group">
       <textarea class="form-control" id="product-description" name="product-description" rows="3" placeholder="Product description" required="required"></textarea>
     </div>

     <div class="form-group">
       <input type="text" class="form-control" id="product-tags" name="product-tags" placeholder="Product Tags (seperated with commas)">
     </div>

     <div class="form-group">
       <input type="text" class="form-control" id="product-url" name="product-url"placeholder="Product Url">
     </div>

     <div class="form-check mb-4 text-left">
       <input class="form-check-input" type="checkbox" value="true" id="terms-service" name="terms-service" required="required">
       <label class="form-check-label" for="defaultCheck1">
         Do you accept the <a href="#">Terms of service</a>
       </label>
     </div>

     <input type="hidden" id="product-image" name="product-image" value="" required="required"/>

    <button type="submit" id="send-mcj" class="btn btn-primary d-none" value="submit" name="submit">Create Product</button>
  </form>

  <div class="text-center">
    <button type="submit" id="create-product-button" class="btn btn-primary" onclick="imageLink()" value="submit" name="submit">Create Product</button>
  </div>

</div>


<?php
  }
?>

<!-- /////////////////////////////////////JAVASCRIPT STUFF ///////////////////////////////////////// -->

<script>
function imageLink() {
  var images = document.getElementsByClassName("fpd-item");
  var hasImage = false;
  Array.prototype.forEach.call(images, function(image) {
    // Do stuff here
    if(image.getAttribute('data-title') !== null && !hasImage){
      // console.log(image.getAttribute('data-title'));
      document.getElementById('product-image').value = image.getAttribute('data-title');
      hasImage = true;
    }
  });
}
</script>

<!-- CALCULATE PROFIT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>
$(document).ready(function(){

    //HIDE FPD FORM
    $("form[name='fpd_shortcode_form']").hide();

    // CALCULATE PROFIT
    $("input").change(function(){
        var basePrice = $("#original-base-price").html().replace('Base Price: $', '');
        var yourPrice = $("#your-price").val();
        var profit = parseFloat(yourPrice - parseFloat(basePrice));
        $("#profit").text('Profit $' + profit.toFixed(2));
    });

    // UPDATE HIDDEN FPD VALUES
    $("input").change(function(){
        var hiddenName =
              "product-name: " + $("#product-name").val() +
              ", price: " + $("#your-price").val() +
              ", vendor-id: " + "<?php echo $vendor_id;?>" +
              ", vendor-name: " + "<?php echo $vendor_name;?>" +
              ", vendor-url: " + "<?php echo get_home_url() . '/vendor/' . $vendor_url;?>"
              ;
        var hiddenEmail =
            "<?php
              $current_user = wp_get_current_user();
              echo $current_user->user_email;
            ?>"
              ;

        $("input[name='fpd_shortcode_form_name']").val(hiddenName);
        $("input[name='fpd_shortcode_form_email']").val(hiddenEmail);
    });

    // WHEN CLICK CREATE PRODUCT
    $("#create-product-button").click(function(){
      var image = $("#product-image").val();
      if(image.length > 0){
        $(".fpd-blue-btn").click();
          $("#create-product-button").text("wait.. processing");
        setTimeout(function(){
          $("#send-mcj").click();
        },2500);
      }
    });

});

</script>


<?php
} // end of else from vendor id check
?>




<!-- <?php  global $wp_roles;
    $all_roles = $wp_roles->roles;
    $editable_roles = apply_filters('editable_roles', $all_roles);
    print_r( $editable_roles); ?> -->


<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
