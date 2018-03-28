<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Select Template</title>
<?php get_header(); ?>

<h1>Select Template</h1>

<div class="row my-5">


<?php

$term = $wp_query->get_queried_object();
  // echo ''. $term->name . '';
  // echo ''. $term->term_id .'';

$the_query = new WP_Query( array(
    'post_type' => 'template',
    'tax_query' => array(
        array (
            'taxonomy' => 'template-category',
            'field' => 'id',
            'terms' => $term->term_id,
        )
    ),
) );

while ( $the_query->have_posts() ) :
    $the_query->the_post();
    // Show Posts ...
?>
    <div class="col-12 col-md-6 col-xl">
      <a href="<?php echo get_permalink() ?>">
      <div class="card">
        <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url() ;?>" alt="Card image cap">
        <div class="card-body row">
          <div class="col">
            <h4 class="card-title font-weight-bold mb-2"><?php echo get_the_title();?></h5>
            <p class="card-text mb-2"><?php echo get_the_content() ?></p>
          </div>

          <div class="col-12 col-lg-5 my-auto">
            <h5 class="font-weight-bold mb-2">
              <?php
                echo 'Base Price: $' . get_post_meta($post ->ID, 'base_price',true);
              ?>
            </h4>

          </div>

        </div>
      </div>
      </a>




    </div>


<?php
endwhile;

wp_reset_postdata();

?>
</div>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
