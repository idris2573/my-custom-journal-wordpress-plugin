<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Select Product Type</title>
<?php get_header(); ?>


</head>
<body>

<?php
if(!current_user_can('wc_product_vendors_admin_vendor') && !current_user_can('administrator')){

echo '<h2>You need to be a vendor to add a product</h2>';
echo do_shortcode("[wcpv_registration]");

}else{
?>

<h1>Select Product Type</h1>
<div id="add-product" class="mb-5 d-lg-flex w-fit-content mx-auto">


<?php
$customPostTaxonomies = get_object_taxonomies('template');

if(count($customPostTaxonomies) > 0){
     foreach($customPostTaxonomies as $tax){
	     $args = array(
         	  'orderby' => 'name',
	          'show_count' => 0,
        	  'pad_counts' => 0,
	          'hierarchical' => 1,
        	  'taxonomy' => $tax,
        	  'title_li' => '',
            'hide_empty' => 0
        	);

	     wp_list_categories( $args );
     }
}
?>
</div>
<?php } ?>















<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
