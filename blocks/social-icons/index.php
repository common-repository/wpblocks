<?php
/**
 * WPBlocks Block Social Icons
 *
 * @package    WPBlocks
 * @author     Hristina Zlateska
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018
 */
class WPBlocks_Social_Icons {

	/**
	 * Block Slug. The same one that's used in registerBlockType.
	 *
	 * @since 1.0.0
	 */
	var $slug;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( ! wpblocks_settings( 'wpblocks-social-icons' ) ) {
			return;
		}

		$this->slug = 'social-icons';
		
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	/**
	 * Enqueue required assets
	 *
	 * @since 1.0.0
	 */
	public function plugins_loaded() {

		add_action( 'enqueue_block_assets', 		array( $this, 'enqueue_block_assets' ) );
		add_action( 'enqueue_block_editor_assets', 	array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Enqueue block assets.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_assets() {

		wp_enqueue_style(
			'wpblocks-gutenberg-style-' . $this->slug,
			WPBLOCKS_PLUGIN_URL . 'blocks/' . $this->slug . '/style.css',
			array( 'wp-blocks' ), 
			WPBLOCKS_VERSION
		);
	}

	/**
	 * Enqueue required assets for Gutenberg Editor
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {

		wp_enqueue_script(
			'wpblocks-gutenberg-editor-' . $this->slug,
			WPBLOCKS_PLUGIN_URL . 'blocks/' . $this->slug . '/block.build.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			WPBLOCKS_VERSION
		);

		wp_enqueue_style(
			'wpblocks-gutenberg-editor-style-' . $this->slug,
			WPBLOCKS_PLUGIN_URL . 'blocks/' . $this->slug . '/style.css',
			array( 'wp-edit-blocks' ), 
			WPBLOCKS_VERSION
		);
	}
}
new WPBlocks_Social_Icons;