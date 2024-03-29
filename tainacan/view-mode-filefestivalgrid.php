<?php
	$is_in_grid_two = $request['view_mode'] === 'filefestivalgrid2';

	$collection_id_works = get_theme_mod('filefestival_tainacan_single_item_template_works', '');
	$collection_id_participants = get_theme_mod('filefestival_tainacan_single_item_template_participants', '');
	$collection_id_events = get_theme_mod('filefestival_tainacan_single_item_template_events', '');
	$collection_id_activities = get_theme_mod('filefestival_tainacan_single_item_template_activities', '');
	$collection_id_publications = get_theme_mod('filefestival_tainacan_single_item_template_publications', '');
	$collection_id_places = get_theme_mod('filefestival_tainacan_single_item_template_places', '');

	// In this variation of the view mode, we have to fetch the second metadata
	if ( $is_in_grid_two ) {

		$metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
		$metadata_objects = [];
		$is_repository_level = !isset($request['collection_id']);
		
		if ( !$is_repository_level ) {
			$collection = tainacan_get_collection([ 'collection_id' => $request['collection_id'] ]);
			$metadata_objects = $metadata_repository->fetch_by_collection(
				$collection,
				[
					'posts_per_page' => 50,
					// 'post_status' => 'publish'
				],
				'OBJECT'
			);
		} else {
			$metadata_objects = $metadata_repository->fetch(
				[ 
					'meta_query' => [
						[
							'key'     => 'collection_id',
							'value'   => 'default',
							'compare' => '='
						]
					],
					// 'post_status' => 'publish',
					'posts_per_page' => 50,
					'include_control_metadata_types' => true
				],
				'OBJECT'
			);
		}
		if ( count($metadata_objects) < 2 ) {
			$is_in_grid_two = false;
		}
	}
?>

<?php if ( have_posts() ) : ?>
	<ul class="tainacan-filefestival-grid-container">

		<?php $item_index = 0; while ( have_posts() ) : the_post(); ?>
			
			<li class="tainacan-filefestival-grid-item">
				<a href="<?php echo get_item_link_for_navigation(get_permalink(), $item_index); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="filefestival-grid-item-thumbnail">
							<?php the_post_thumbnail( 'large' ); ?>
							<!-- <?php tainacan_the_document(); ?> -->
							<div class="skeleton"></div> 
						</div>
					<?php else : ?>
						<div class="filefestival-grid-item-thumbnail">
							<?php echo '<img alt="', esc_attr_e('Minatura da imagem do item', 'filefestival'), '" src="', esc_url(get_stylesheet_directory_uri()), '/images/thumbnail_placeholder.png">'?>
							<div class="skeleton"></div> 
						</div>
					<?php endif; ?>

					<?php
							$collection_id = str_replace('_item', '', str_replace('tnc_col_', '', get_post_type()));
							$title_class = 'metadata-title';

							if (
								$collection_id == $collection_id_works ||
								$collection_id == $collection_id_participants ||
								$collection_id == $collection_id_events ||
								$collection_id == $collection_id_places
							) {
								$title_class .= ' notranslate';
							}
						?>

					<div class="<?php echo $title_class; ?>">
						<h3><?php the_title(); ?></h3>
					</div>
					<?php if ( $is_in_grid_two ) : ?>
						<div class="metadata-description">
							<p>
								<?php
									foreach($metadata_objects as $metadata_object) {
										if ( $metadata_object->get_metadata_type() !== 'Tainacan\Metadata_Types\Core_Title' ) {
											$second_metadata_value = tainacan_get_the_metadata([ 'metadata' => $metadata_object ]);
											if ( !empty($second_metadata_value) ) {
												echo $second_metadata_value;
												break;
											}
										}
									}
								?>
							</p>
						</div>
					<?php endif; ?>
				</a>
			</li>	
		
		<?php $item_index++; endwhile; ?>
	
	</ul>

<?php else : ?>
	<div class="tainacan-filefestival-grid-container">
		<section class="section">
			<div class="content has-text-gray-4 has-text-centered">
				<p>
					<span class="icon is-large">
						<i class="tainacan-icon tainacan-icon-48px tainacan-icon-items"></i>
					</span>
				</p>
				<p><?php echo __( 'Nenhum item encontrado.','filefestival' ); ?></p>
			</div>
		</section>
	</div>
<?php endif; ?>
