<?php

  // ADDING TEMPLATE CUSTOM POST TYPE

  add_action( 'init','custom_post_type' );

  function custom_post_type(){

      register_taxonomy(
        'template-category',
        'template',
        array(
          'label' => 'Template Category',
          'hierarchical' => true, )
    );

      register_post_type( 'template', [
        'public' => true,
        'label' => 'Templates',
        'taxonomies' => array( 'template-category' ),
        'supports' => array(
          'title',
          'thumbnail',
          'editor',
          // 'custom-fields'
        )
      ]
    );
  }

  // META BOX ADDING
  add_action('add_meta_boxes', 'base_price_box');

  function base_price_box(){
      add_meta_box(
    		'base_price',
    		'Base Price',
    		'base_price_box_content',
    		'template',
    		'side',
    		'high'
    	);
  }

  function base_price_box_content($post){
    wp_nonce_field( plugin_basename( __FILE__ ), 'base_price_box_content_nonce' );

    $price = get_post_meta($post ->ID, 'base_price',true);

    echo '$ <input type="number" class="form-control" id="base_price" name="base_price" min="0.01" step="0.01" max="2500" value="' . $price . '" required="required">';
  }

  add_action( 'save_post', 'base_price_box_save' );

  function base_price_box_save($post_id){
    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ){
      return;
    }

    if ( !wp_verify_nonce( $_POST['base_price_box_content_nonce'], plugin_basename( __FILE__ ) ) ){
      return;
    }

    if ( 'page' == $_POST['post_type'] ){
      if (!current_user_can( 'edit_page', $post_id) ){
        return;
      }
    } else {
      if (!current_user_can( 'edit_page', $post_id) ){
        return;
      }
    }

    $base_price = $_POST[ 'base_price' ];
    update_post_meta( $post_id, 'base_price', $base_price );


  }





?>
