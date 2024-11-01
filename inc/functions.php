<?php
/**
 * Contains various functions that may be potentially used throughout
 * the WPBlocks plugin.
 *
 * @package    WPBlocks
 * @author     Hristina Zlateska
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018
 */


/**
 * Get the value of a specific WPBlocks setting.
 *
 * @since 1.0.0
 * @return mixed
 */
function wpblocks_settings( $key, $options = false, $default = false, $option_slug = WPBLOCKS_SETTINGS  ) {

	if ( false === $options ) {
		$options = get_option( $option_slug, false );
	}

	$value = is_array( $options ) && ! empty( $options[ $key ] ) ? $options[ $key ] : $default;
	return $value == 'on' ? true : $value;
}