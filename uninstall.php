<?php
/**
 * Uninstall WPBlocks
 *
 * Deletes all the plugin data.
 *
 * @package    WPBlocks
 * @author     Hristina Zlateska
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018, WPBlocks
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

global $wpdb;

/**
 * Remove WPBlocks data
 *
 * @since 1.0.0
 */
function wpblocks_uninstall() {

	/** Delete all the Plugin Options */
	delete_option( 'wpblocks_settings' );
}

// Check if we are on multisite
if ( function_exists( 'is_multisite') && is_multisite() ) {
	
	// Multisite - go through each subsite and run the uninstaller
	if ( function_exists( 'get_sites' ) && class_exists( 'WP_Site_Query' ) ) {
		
		$sites = get_sites();
		
		foreach ( $sites as $site ) {
			switch_to_blog( $site->blog_id );
			wpblocks_uninstall();
			restore_current_blog();
		}
	} else {

		$sites = wp_get_sites( array( 'limit' => 0 ) );
		
		foreach ( $sites as $site ) {
			switch_to_blog( $site['blog_id'] );
			wpblocks_uninstall();
			restore_current_blog();
		}
	}
} else {
	// Normal single site
	wpblocks_uninstall();
}

// Clear any cached data that has been removed
wp_cache_flush();