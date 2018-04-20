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

    // wp_nonce_field( plugin_basename( __FILE__ ), 'base_price_box_content_nonce' );
    wp_nonce_field( basename( __FILE__ ), 'base_price_box_content_nonce' );


    $price = get_post_meta($post ->ID, 'base_price',true);

    echo '$ <input type="number" class="form-control" id="base_price" name="base_price" min="0.01" step="0.01" max="2500" value="' . $price . '" required="required">';
  }

  // add_action( 'save_post', 'base_price_box_save' );
  add_action( 'save_post', 'base_price_box_save', 1, 2 );

  function base_price_box_save( $post_id, $post ) {
  	// Return if the user doesn't have edit permissions.
  	if ( ! current_user_can( 'edit_post', $post_id ) ) {
  		return $post_id;
  	}
  	// Verify this came from the our screen and with proper authorization,
  	// because save_post can be triggered at other times.
  	if ( ! isset( $_POST['base_price'] ) || ! wp_verify_nonce( $_POST['base_price_box_content_nonce'], basename(__FILE__) ) ) {
  		return $post_id;
  	}
  	// Now that we're authenticated, time to save the data.
  	// This sanitizes the data from the field and saves it into an array $events_meta.
  	$events_meta['base_price'] = esc_textarea( $_POST['base_price'] );
  	// Cycle through the $events_meta array.
  	// Note, in this example we just have one item, but this is helpful if you have multiple.
  	foreach ( $events_meta as $key => $value ) :
  		// Don't store custom data twice
  		if ( 'revision' === $post->post_type ) {
  			return;
  		}
  		if ( get_post_meta( $post_id, $key, false ) ) {
  			// If the custom field already has a value, update it.
  			update_post_meta( $post_id, $key, $value );
  		} else {
  			// If the custom field doesn't have a value, add it.
  			add_post_meta( $post_id, $key, $value);
  		}
  		if ( ! $value ) {
  			// Delete the meta key if there's no value
  			delete_post_meta( $post_id, $key );
  		}
  	endforeach;
  }




?>
