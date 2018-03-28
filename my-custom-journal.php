<?php
/*
 * @package MyCustomJournal
 */
/*
Plugin Name: My Custom Journal
Plugin URI: http://idriskadri.com
Description: My Custom Journal
Version: 1.0.0
Author: Idris Kadri
Author URI: http://idriskadri.com
License:
Text Domain: my-custom-journal
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Include the main WooCommerce class.
if ( ! class_exists( 'MyCustomJournal' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-my-custom-journal.php';
	$myCustomJournal = new MyCustomJournal();
	$myCustomJournal->register();
}

// activate plugin
register_activation_hook( __FILE__, array( $myCustomJournal, 'activate' ) );

include('includes/template-post-type.php');

// deactivate plugin
register_deactivation_hook( __FILE__, array( $myCustomJournal, 'deactivate' ) );
