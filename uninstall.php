<?php

/**
 * Trigger thie file on Plugin uninstall
 *
 * @package MyCustomJournal
 */

 if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
 	exit;
 }

 // Clear Database stored data

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'template'" );
$wpdb->query( "DELETE FROM wp_postsmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_termrelationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
