<?php
/**
 * MyCustomJournal setup
 *
 * @package  MyCustomJournal
 * @since    1.0.0
 */

final class MyCustomJournal {

  function __construct() {
    // init = initialization
    $this->plugin = plugin_basename( __FILE__ );
  }

  function register() {
    // on the front end
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue') );
    // on the back end
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin') );

    add_action( 'wp', array( $this, 'get_pages') );

    add_filter( 'single_template',  array( $this, 'set_product_template' ) );

    add_action( 'template_include', array( $this, 'set_category_template') );

    add_action( 'admin_menu', array( $this, 'remove_menus') );

    add_action( 'admin_menu', array( $this, 'add_custom_link_into_appearance_menu') );

  }

  function activate() {
    // genereated a custom post type
    // flush rewrite rules
    flush_rewrite_rules();
  }

  function deactivate() {
    // flush rewrite rules
    flush_rewrite_rules();
  }



  function enqueue() {
    // enqueue all our scripts
    wp_enqueue_style( 'mypluginstyle', plugins_url( '../assets/style.css', __FILE__ ) );
    wp_enqueue_style( 'mypluginscript', plugins_url( '../assets/script.js', __FILE__ ) );
  }

  function enqueue_admin() {
    // enqueue all our scripts
    wp_enqueue_style( 'mypluginstyle', plugins_url( '../assets/style-admin.css', __FILE__ ) );
    wp_enqueue_style( 'mypluginscript', plugins_url( '../assets/script-admin.js', __FILE__ ) );
  }


  function get_pages()  {
  	if(is_page('add-product')){
  		$dir = plugin_dir_path( __FILE__ );
  		include($dir."../templates/add-product.php");
  		die();
  	}
  }

  function set_product_template( $template ){
    global $post;
    if ($post->post_type == 'template') {
         $template = plugin_dir_path( __FILE__ ).'../templates/single-template.php';
    }
    return $template;
  }


    function set_category_template( $template ){
      if( is_tax('template-category')){
        $template = plugin_dir_path( __FILE__ ).'../templates/category-template.php';
      }
      return $template;
    }

////////////////////////////////////ADMIN STUFF/////////////////////////////////////////


  function remove_menus() {
    //CHECKS IF IS ADMIUN
    if( current_user_can('editor') || current_user_can('administrator') ) {
      return;
    }

    // remove menus
    remove_menu_page( 'upload.php' );
    remove_menu_page( 'profile.php' );
    remove_submenu_page( 'edit.php?post_type=product','post-new.php?post_type=product' );
  }

  function add_custom_link_into_appearance_menu() {
    global $submenu;
    $permalink = '/mycustomjournal/add-product/';
    $submenu['edit.php?post_type=product'][] = array( 'Add Product', 'add-product', $permalink );

    $role = get_role('wc_product_vendors_admin_vendor');
    $role->add_cap('add-product');

  }












    // public function add_admin_pages() {
    //   // page title, menu title, capability users, menu slug, callback function, icon, position in sidebar
    //   // add_menu_page( 'MyCustomJournal Plugin', 'MyCustomJournal', 'manage_options', 'mycustomjournal_plugin', array( $this, 'admin_index' ), 'dashicons-store', 200  );
    //
    //   add_menu_page('Products', 'Products', 'mcj_products', 'mcj-products',  array( $this, 'admin_products' ) );
    //   add_submenu_page( 'mcj-products', 'Add Product', 'Add Products', 'mcj_products', 'mcj-products-add', array( $this, 'admin_product_add' ));
    //
    //   $subs = get_role('wc_product_vendors_admin_vendor');
    //   $subs->add_cap('mcj_products');
    // }


    // public function admin_product_add() {
    //   require_once plugin_dir_path( __FILE__ ) . '../templates/admin-product-add.php';
    // }
    //
    // public function admin_products() {
    //   require_once plugin_dir_path( __FILE__ ) . '../templates/admin-products.php';
    // }

}
