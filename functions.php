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

/* Registers File Festival Custom View Modes */
function filefestival_register_tainacan_view_modes() {
	if ( function_exists( 'tainacan_register_view_mode' ) ) {

		// Grid
		tainacan_register_view_mode('filefestivalgrid', array(
			'label' => __( 'Cartões', 'filefestival' ),
			'description' => __( 'Uma grade de itens feita para o festival FILE', 'filefestival' ),
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewrecords tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => false,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-filefestivalgrid.php'
		));

		// List
		tainacan_register_view_mode('filefestivallist', array(
			'label' => __( 'Lista', 'filefestival' ),
			'description' => __( 'Uma lista de itens feita para o festival FILE', 'filefestival' ),
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewlist tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => true,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-filefestivallist.php'
		));

		// Table
		tainacan_register_view_mode('filefestivaltable', array(
			'label' => __( 'Tabela', 'filefestival' ),
			'description' => __( 'Uma tabela de itens feita para o festival FILE', 'filefestival' ),
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewtable tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => true,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-filefestivaltable.php'
		));
	}
}
add_action( 'after_setup_theme', 'filefestival_register_tainacan_view_modes' );