<?php	
	get_header();
	
	$Tainacan_Collections = \Tainacan\Repositories\Collections::get_instance();

	$collections = $Tainacan_Collections->fetch(
		array(
			'posts_per_page' => 10
		)
	, 'OBJECT' );

	if ( is_array($collections) && count($collections) >= 0 ) {
	
		$collections_links_html = '';

		ob_start();
		?>
		<nav>
			<ul class="tainacan-collections-links">
				<?php foreach($collections as $collection) : ?>
					<li><a href="<?php echo $collection->get_url(); ?>"><?php echo $collection->get_name(); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<div class="tainacan-items-list-heading">
			<h1><?php tainacan_the_term_name(); ?></h1>
			<p><?php tainacan_the_term_description(); ?></p>
		</div>
		<?php

		$collections_links_html = ob_get_contents();
		ob_clean();

		if ( !empty($collections_links_html) ) {
			echo '<script type="text/javascript">
					wp.hooks.addFilter("tainacan_faceted_search_collection_' . tainacan_get_collection_id() . '_search_control_before", "tainacan-hooks", function() { return `' . $collections_links_html . '`; });
				</script>';
		}
	}
	
?>

<div class="entry-content">

    <section class="alignwide">

		<?php 
			tainacan_the_faceted_search([
				'enabled_view_modes' => [ 'filefestivalgrid', 'filefestivalgrid2', 'filefestivallist', 'filefestivaltable' ],
				'default_view_mode' => 'filefestivalgrid',
				'default_items_per_page' => 12,
				'hide_filters' => false,
				'hide_hide_filters_button' => false,
				'hide_search' => true,
				'hide_advanced_search' => true,
				'hide_sort_by_button' => false,
				'hide_exposers_button' => false,
				'hide_items_per_page_button' => false,
				'hide_go_to_page_button' => false,
				'show_filters_button_inside_search_control' => true,
				'start_with_filters_hidden' => false,
				'filters_as_modal' => false,
				'show_inline_view_mode_options' => false,
				'show_fullscreen_with_view_modes' => true
			]); 
		?>

	</section>
</div>
<?php get_footer(); ?>
