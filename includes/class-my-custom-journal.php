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

    add_action( 'wp_before_admin_bar_render', array( $this, 'add_logo_help_links_and_remove_user_details') );

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

  function add_logo_help_links_and_remove_user_details() {
    echo '<style type="text/css">
      #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
      background-position: 0 0;
      }
      #wpadminbar{
        height: 60px !important;
      }
      #wpadminbar img{
        height: 40px !important;
        margin-left: 10px;
        margin-top: 5px;
        margin-right: 10px;
      }
      #wpbody-content{
        margin-top:40px;
      }
      .sticky-menu #adminmenuwrap{
        margin-top: 20px !important;
      }
      #wpadminbar .quicklinks .ab-empty-item, #wpadminbar .quicklinks a, #wpadminbar .shortlink-input{
        height: 50px;
      }

      #help-links{

      }

      .help-images{
        width: 200px;
      }

      .help-images img{
        width: 200px;
      }

      #help-links li{
        width:100%;
        text-align: center;
        font-size: 24px;
        margin-bottom:20px;
      }

      @media (min-width: 550px) {
        #help-links{
          display:flex;
        }

        #help-links li{
          width:50%;

        }
      }

      @media (min-width: 1500px) {
        #help-links{
          width:33%;
        }
      }

      @media (min-width: 1680px) {
        #help-links{
          width:100%;
        }
      }
      </style>
      ';

      global $wp;
      $current_url = home_url(add_query_arg($_GET,$wp->request));
      if(strpos($current_url, 'fancy_product_designer') ||
         strpos($current_url, 'fpd_product_builder') ||
         strpos($current_url, 'fpd_ui_layout_composer') ||
         strpos($current_url, 'fpd_manage_designs') ||
         strpos($current_url, 'fpd_orders') ||
         strpos($current_url, 'fpd_settings')
      ){
        return;
      }

      echo '
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

      <script>
        $(document).ready(function(){

          $("#wp-admin-bar-site-name").html(\'<img src="' . plugin_dir_url( __FILE__ ) . '../images/logo.png">\');

          if( document.location.href.indexOf("wp-admin/index.php") > -1 && $("#contextual-help-link").text() != "Help"){
            $("#side-sortables").html(\'<ul id="help-links"><li><a href="https://sellers.mycustomjournal.com" class="middle"><img class="help-images" src="' . plugin_dir_url( __FILE__ ) . '../images/training.png"></a></li><li><a class="help-images" href="https://support.mycustomjournal.com" class="middle"><img src="' . plugin_dir_url( __FILE__ ) . '../images/support.png"></a></li></ul>\');
          }

          if( document.location.href.indexOf("wcpv-vendor-orders") > -1 && $("#contextual-help-link").text() != "Help"){
            $("th:nth-child(5)").remove();
            $("td:nth-child(5)").remove();
          }

          if( document.location.href.indexOf("wcpv-vendor-order") > -1 && $("#contextual-help-link").text() != "Help"){
            $("h4").each(function(){
              if($(this).text() == "Billing Details" || $(this).text() == "Shipping Details" ){
                $(this).remove();
              }
            })
            $(".address").remove();
          }

        });
      </script>
      ';
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
