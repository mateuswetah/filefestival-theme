<?php
/**
 * Twenty Twenty One Child functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package filefestival
 */

 CONST FILEFESTIVAL_THEME_VERSION = '0.6.5';

/**
 * Enqueue scripts and styles.
 */
function filefestival_parent_theme_enqueue_styles() {
	//wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'filefestival',
		get_stylesheet_directory_uri() . '/style.min.css',
		array( 'twenty-twenty-one-style' ),
		FILEFESTIVAL_THEME_VERSION
	);

	// Enqueues popper and tippy to allow display of tooltips
	wp_enqueue_script( 'filefestival-popper', 'https://unpkg.com/@popperjs/core@2', [], FILEFESTIVAL_THEME_VERSION);
	wp_enqueue_script( 'filefestival-tippy', 'https://unpkg.com/tippy.js@6', [], FILEFESTIVAL_THEME_VERSION);
	wp_enqueue_style( 'filefestival-tippy-theme', 'https://unpkg.com/tippy.js@6/themes/light-border.css', [], FILEFESTIVAL_THEME_VERSION);
	wp_enqueue_script( 'filefestival-tooltips', get_stylesheet_directory_uri() . '/js/tooltips.js', [], FILEFESTIVAL_THEME_VERSION, true);
}
add_action( 'wp_enqueue_scripts', 'filefestival_parent_theme_enqueue_styles' );


/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function filefestival_editor_styles() {
	wp_enqueue_style( 'filefestival_editor_styles', get_stylesheet_directory_uri() . '/editor.min.css', array(), FILEFESTIVAL_THEME_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'filefestival_editor_styles' );

/* Registers File Festival Custom View Modes */
function filefestival_register_tainacan_view_modes() {
	if ( function_exists( 'tainacan_register_view_mode' ) ) {

		// Grid
		tainacan_register_view_mode('filefestivalgrid', array(
			'label' => __( 'Cartões', 'filefestival' ),
			'description' => __( 'Uma grade de itens feita para o festival FILE', 'filefestival' ),
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewcards tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => false,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-filefestivalgrid.php'
		));

		// Grid 2
		tainacan_register_view_mode('filefestivalgrid2', array(
			'label' => __( 'Fichas', 'filefestival' ),
			'description' => __( 'Uma ficha de itens com mais informações que a grade, feita para o festival FILE', 'filefestival' ),
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


/**
 *  
 * Loads text domain files from the languages folder 
 * 
 */
function filefestival_add_translations() {
	load_theme_textdomain('filefestival', get_stylesheet_directory() . '/languages');
}
add_action( 'after_setup_theme', 'filefestival_add_translations' );

/**
 * Retrieves an item adjacent link, either using WP strategy or Tainacan plugin tainacan_get_adjacent_items()
 * 
 * @param string $thumbnail: accepts 'small' and 'large', defaults to null
 */
function tainacan_get_adjacent_item_links($thumbnail = null) {

	if (function_exists('tainacan_get_adjacent_items') && isset($_GET['pos'])) {
		$adjacent_items = tainacan_get_adjacent_items();

		if (isset($adjacent_items['next'])) {
			$next_link_url = $adjacent_items['next']['url'];
			$next_title = __('Próximo', 'filefestival');//$adjacent_items['next']['title'];
		} else {
			$next_link_url = false;
		}
		if (isset($adjacent_items['previous'])) {
			$previous_link_url = $adjacent_items['previous']['url'];
			$previous_title = __('Anterior', 'filefestival');//$adjacent_items['previous']['title'];
		} else {
			$previous_link_url = false;
		}

	} else {
		//Get the links to the Previous and Next Post
		$previous_link_url = get_permalink( get_previous_post() );
		$next_link_url = get_permalink( get_next_post() );

		//Get the title of the previous post and next post
		$previous_title = __('Anterior', 'filefestival');//get_the_title( get_previous_post() );
		$next_title = __('Próximo', 'filefestival');//get_the_title( get_next_post() );
	}

	$previous = $previous_link_url === false ? '' : '<a rel="prev" href="' . $previous_link_url . '"><svg id="Camada_1" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.56 13.58"><path id="next-2" class="cls-1" d="M0,13V.58H0v0H0A.57.57,0,0,1,.58,0h1.1a.59.59,0,0,1,.58.57.25.25,0,0,0,0,.08V5.9L9.8,1.54a.37.37,0,0,1,.54,0,.32.32,0,0,1,.12.26h0V5.25L16.9,1.53a.38.38,0,0,1,.55,0,.36.36,0,0,1,.11.26h0v10a.39.39,0,0,1-.39.38.43.43,0,0,1-.28-.11L10.46,8.33v3.44a.39.39,0,0,1-.39.39A.39.39,0,0,1,9.79,12L2.25,7.69V13h0v0a.58.58,0,0,1-.58.57H.57A.57.57,0,0,1,0,13H0v0Z"/></svg><span>' . $previous_title . '</span></a>';
	$next = $next_link_url === false ? '' :'<a rel="next" href="' . $next_link_url . '"><svg id="Camada_1" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.56 13.57"><path id="next" class="cls-1" d="M17.56,13V.58h0V.52h0A.57.57,0,0,0,17,0h-1.1a.57.57,0,0,0-.57.57V5.9L7.76,1.53a.39.39,0,0,0-.55,0,.41.41,0,0,0-.11.26h0V5.25L.66,1.53a.39.39,0,0,0-.55,0A.36.36,0,0,0,0,1.8H0v10a.39.39,0,0,0,.39.39A.39.39,0,0,0,.67,12L7.1,8.32v3.44a.39.39,0,0,0,.39.39A.36.36,0,0,0,7.77,12l7.54-4.35V13h0v0a.57.57,0,0,0,.58.57H17a.58.58,0,0,0,.57-.57v0Z"/></svg><span>' . $next_title . '</span></a>';

	return ['next' => $next, 'previous' => $previous];
}


/**
 * Retrieves the current items list source link
 */
function tainacan_get_source_item_list_url() {
	$args = $_GET;
	if (isset($args['ref'])) {
		$ref = $_GET['ref'];
		unset($args['pos']);
		unset($args['ref']);
		unset($args['source_list']);
		return $ref . '?' . http_build_query(array_merge($args));
	} else {
		unset($args['pos']);
		unset($args['ref']);
		unset($args['source_list']);
		return tainacan_the_collection_url() . '?' . http_build_query(array_merge($args));
	}
}


/**
 * Adds class to style different body layout in colections list
 */
function filefestival_adds_collection_layout_class( $classes ) {

	if ( isset($_GET['viewmode']) && is_post_type_archive( 'tainacan-collection' ) )
    	return array_merge( $classes, array( 'collections-list-layout-' . $_GET['viewmode'] ) );

	return $classes;
}
add_filter( 'body_class', 'filefestival_adds_collection_layout_class' );


/**
 * Filters the loop on collections list to set greater posts per page
 */
function filefestival_modify_collections_query( $wp_query ) {
    if ( is_post_type_archive('tainacan-collection') && isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] === 'tainacan-collection' ) {
		$wp_query->query_vars['posts_per_page'] = 64;

		$subscription_collection_id = get_theme_mod('filefestival_tainacan_collection_subscription', '');
		if ( !empty($subscription_collection_id) ) {
    		$wp_query->query_vars['post__not_in'] = [ $subscription_collection_id ];
		}
	} else
		return;
}
add_filter( 'pre_get_posts', 'filefestival_modify_collections_query' );

/**
 * Allows upload of SVG files
 */
function filefestival_upload_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'application/x-gzip';
	return $mimes;
}
add_filter( 'upload_mimes', 'filefestival_upload_mime_types' );

/**
 * Add search box to primary menu
 */
function filefestival_nav_search($items, $args) {
    // If this isn't the primary menu, do nothing
    if ( !($args->theme_location == 'primary') ) 
    	return $items;

	$tainacan_search_bar = '';
	ob_start();

	?>
	<li class="menu-item menu-item--search">
		<div
				class="wp-block-tainacan-search-bar is-style-default"
				data-module="search-bar">
			<div class="tainacan-search-container">
				<form 
						id="tainacan-search-bar-block"
						action="<?php echo (esc_url_raw( get_site_url() ) . '/' . \Tainacan\Theme_Helper::get_instance()->get_items_list_slug()); ?>"
						data-queryparam="search"
						method="get">
					<input
							id="tainacan-search-bar-block_input"
							label="<?php echo __('Busca', 'filefestival') ?>"
							name="search"
							placeholder="<?php echo __('Busca', 'filefestival') ?>...">
					<button
							class="button"
							type="submit">
						<span class="icon">
							<i>
							<svg
									width="16"
									height="16"
									viewBox="0 0 16 16"
									fill="none"
									xmlns="http://www.w3.org/2000/svg">
								<path d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z" stroke="#707070" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M14 14.0001L11.1 11.1001" stroke="#707070" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							</i>
						</span>
					</button>
				</form>
			</div>
		</div>
	</li>
	<?php

	$tainacan_search_bar = ob_get_contents();
	ob_clean();

    // Otherwise, add search form
    return $items . $tainacan_search_bar;
}
add_filter('wp_nav_menu_items', 'filefestival_nav_search', 10, 2);

/**
 * Adds 'notranslate' class to item metadatum values of titles and relationships
 */
add_filter('tainacan-get-item-metadatum-as-html-before-value', function($before, $item_metadatum) {
	
	if ( $item_metadatum ) {
		$metadatum = $item_metadatum->get_metadatum();

		if ( $metadatum ) {
			$metadata_type = $metadatum->get_metadata_type();

			if ( $metadata_type === 'Tainacan\Metadata_Types\Core_Title' || $metadata_type === 'Tainacan\Metadata_Types\Relationship' ) {
				return str_replace('tainacan-metadatum-value', 'tainacan-metadatum-value notranslate', $before);
			}
		}
	}
	return $before;

}, 10, 2);

/* Builds navigation link for custom view modes */
function get_item_link_for_navigation($item_url, $index) {
		
	if ( $_GET && isset($_GET['paged']) && isset($_GET['perpage']) ) {
		$query = '';
		$perpage = (int)$_GET['perpage'];
		$paged = (int)$_GET['paged'];
		$index = (int)$index;
		$query .= '&pos=' . ( ($paged - 1) * $perpage + $index );
		$query .= '&source_list=' . (is_tax() ? 'term' : 'collection');
		return $item_url . '?' .  $_SERVER['QUERY_STRING'] . $query;
	}
	return $item_url;
}

// Remaining imports
require_once get_stylesheet_directory() . '/inc/customizer.php';
require_once get_stylesheet_directory() . '/inc/icons.php';
require_once get_stylesheet_directory() . '/inc/editor.php';
require_once get_stylesheet_directory() . '/inc/hooks.php';