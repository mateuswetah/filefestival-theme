<?php
/**
 * Twenty Twenty One Child functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package filefestival
 */

 CONST FILEFESTIVAL_THEME_VERSION = '0.0.2';

/**
 * Enqueue scripts and styles.
 */
function filefestival_parent_theme_enqueue_styles() {
	//wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'filefestival',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twenty-twenty-one-style' ),
		FILEFESTIVAL_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'filefestival_parent_theme_enqueue_styles' );
