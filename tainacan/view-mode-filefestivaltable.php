<?php if ( have_posts() ) : ?>
	<?php 
		$metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
		$metadata_objects = [];
		$is_repository_level = !isset($request['collection_id']);
		$has_title_enabled = true; // in_array('title', $view_mode_displayed_metadata); -- Set to true as it would only work in the repository level
		$has_description_enabled = in_array('description', $view_mode_displayed_metadata);
		$has_meta = isset($view_mode_displayed_metadata['meta']) && count($view_mode_displayed_metadata['meta']) > 0;

		$collection_id_works = get_theme_mod('filefestival_tainacan_single_item_template_works', '');
		$collection_id_participants = get_theme_mod('filefestival_tainacan_single_item_template_participants', '');
		$collection_id_events = get_theme_mod('filefestival_tainacan_single_item_template_events', '');
		$collection_id_activities = get_theme_mod('filefestival_tainacan_single_item_template_activities', '');
		$collection_id_publications = get_theme_mod('filefestival_tainacan_single_item_template_publications', '');
		$collection_id_places = get_theme_mod('filefestival_tainacan_single_item_template_places', '');

		if ( $has_meta ) {
			if ( !$is_repository_level ) {
				$collection = tainacan_get_collection([ 'collection_id' => $request['collection_id'] ]);
				$metadata_objects = $metadata_repository->fetch_by_collection(
					$collection,
					[ 'post__in' => $view_mode_displayed_metadata['meta'] ],
					'OBJECT'
				);
			} else {
				$metadata_objects = $metadata_repository->fetch(
					[ 
						'post__in' => $view_mode_displayed_metadata['meta'],
						'meta_query' => [
							[
								'key'     => 'collection_id',
								'value'   => 'default',
								'compare' => '='
							]
						],
						'include_control_metadata_types' => true
					],
					'OBJECT'
				);
			}
		}
	?>
	<div class="tainacan-filefestival-table-container">
		<table class="tainacan-filefestival-table-container-table">
			<thead>
				<tr>
					<?php if ( $has_title_enabled ): ?>
						<th class="tainacan-text--title"><?php echo __('Título', 'filefestival'); ?></th>
					<?php endif; if ( $is_repository_level && $has_description_enabled ) :?>
						<th class="tainacan-textarea"><?php echo __('Descrição', 'filefestival'); ?></th>
					<?php endif; ?>
					<?php foreach($metadata_objects as $metadatum): 
							$metadatum_component = '';
							$metadatum_object = $metadatum->get_metadata_type_object()->_toArray();
							$metadatum_component = $metadatum_object['component'];
							
							if ( $metadatum_object['related_mapped_prop'] == 'title') {
								continue;
							}
						?>
						<th class="<?php echo $metadatum_component; ?>"><?php echo $metadatum->get_name(); ?> </th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
			<?php $item_index = 0; while ( have_posts() ) : the_post(); ?>
				
				<tr class="tainacan-filefestival-table-item">
					<?php if ( $has_title_enabled ): ?>
						<?php
							$collection_id = str_replace('_item', '', str_replace('tnc_col_', '', get_post_type()));
							$title_class = 'metadata-type-core_title';

							if (
								$collection_id == $collection_id_works ||
								$collection_id == $collection_id_participants ||
								$collection_id == $collection_id_events ||
								$collection_id == $collection_id_places
							) {
								$title_class .= ' notranslate';
							}

						?>
						<td class="<?php echo $title_class; ?>"><a href="<?php echo get_item_link_for_navigation(get_permalink(), $item_index); ?>"><p class="metadata-value"><?php echo get_the_title(); ?></p></a></td>
					<?php endif; if ( $is_repository_level && $has_description_enabled ): ?>
						<td class="metadata-type-core_description"><p class="metadata-value"><?php echo get_the_excerpt(); ?></p></td>
					<?php endif; ?>
					<?php if ( $has_meta ) {
							tainacan_the_metadata(array(
								'exclude_title' => true,
								'metadata__in' => $view_mode_displayed_metadata['meta'],
								'before_title' => '<h3 class="metadata-label">',
								'before_value' => '<p class="metadata-value">',
								'after_title'  => '</h3>',
								'after_value'  => '</p>',
								'before' => '<td class="metadata-type-$type" $id>',
								'after' => '</td>',
								'hide_empty' => false,
								'empty_value_message' => ' - '
							));
						} 
					?>
				</tr>
			
			<?php $item_index++; endwhile; ?>
			</tbody>
		</table>
	</div>

<?php else : ?>
	<div class="tainacan-filefestival-table-container">
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
