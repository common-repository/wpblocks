<?php
/**
 * Plugin Name: WPBlocks
 * Plugin URI:  https://wpblocks.io
 * Description: A collection of additional Gutenberg blocks.
 * Author:      WPBlocks
 * Author URI:  https://wpblocks.io
 * Version:     1.0.0
 * Text Domain: wpblocks
 * Domain Path: languages
 *
 * WPBlocks is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WPBlocks is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WPBlocks. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    WPBlocks
 * @author     Hristina Zlateska
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018, WPBlocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Don't allow multiple versions to be active
if ( class_exists( 'WPBlocks' ) ) {

	/**
	 * Deactivate if WPBlocks is already activated.
	 *
	 * @since 1.0.0
	 */
	function wpblocks_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	add_action( 'admin_init', 'wpblocks_deactivate' );

	/**
	 * Display notice after deactivation.
	 *
	 * @since 1.0.0
	 */
	function wpblocks_notice() {
		
		echo '<div class="notice notice-warning"><p>' . __( 'WPBlocks was deactivated because class WPBlocks already exists.', 'wpblocks' ) . '</p></div>';
		
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

	}
	add_action( 'admin_notices', 'wpblocks_notice' );
} else {

	/**
	 * Main WPBlocks class.
	 *
	 * @since 1.0.0
	 * @package WPBlocks
	 */
	final class WPBlocks {

		/**
		 * Singleton instance of the class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance;

		/**
		 * Plugin version for enqueueing, etc.
		 *
		 * @since 1.0.0
		 * @var sting
		 */
		public $version = '1.0.0';

		/**
		 * Main WPBlocks Instance.
		 *
		 * Insures that only one instance of WPBlocks exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0.0
		 * @return WPBlocks
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPBlocks ) ) {

				self::$instance = new WPBlocks;
				self::$instance->constants();
				self::$instance->load_textdomain();
				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 * Setup plugin constants.
		 *
		 * @since 1.0.0
		 */
		private function constants() {

			// Plugin version
			if ( ! defined( 'WPBLOCKS_VERSION' ) ) {
				define( 'WPBLOCKS_VERSION', $this->version );
			}

			// Plugin Folder Path
			if ( ! defined( 'WPBLOCKS_PLUGIN_DIR' ) ) {
				define( 'WPBLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'WPBLOCKS_PLUGIN_URL' ) ) {
				define( 'WPBLOCKS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'WPBLOCKS_PLUGIN_FILE' ) ) {
				define( 'WPBLOCKS_PLUGIN_FILE', __FILE__ );
			}

			// Plugin Settings
			if ( ! defined( 'WPBLOCKS_SETTINGS' ) ) {
				define( 'WPBLOCKS_SETTINGS', 'wpblocks_settings' );
			}
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since 1.0.0
		 */
		public function load_textdomain() {

			load_plugin_textdomain( 'wpblocks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Include files.
		 *
		 * @since 1.0.0
		 */
		private function includes() {

			require_once WPBLOCKS_PLUGIN_DIR . 'inc/functions.php';					
			require_once WPBLOCKS_PLUGIN_DIR . 'inc/class-settings.php';					

			// Automatically include all blocks
			foreach ( glob( WPBLOCKS_PLUGIN_DIR . 'blocks/**/index.php' ) as $block ) {
				if ( file_exists( $block ) ) {
					require_once $block;					
				}
			}
		}
	}

	/**
	 * The function which returns the one WPBlocks instance.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $wpblocks = wpblocks(); ?>
	 *
	 * @since 1.0.0
	 * @return object
	 */
	function wpblocks() {
		return WPBlocks::instance();
	}

	wpblocks();
}