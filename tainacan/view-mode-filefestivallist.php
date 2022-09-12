<?php if ( have_posts() ) : ?>
	<?php 
		$is_repository_level = !isset($request['collection_id']);
		$has_thumbnail_enabled = in_array('thumbnail', $view_mode_displayed_metadata);
		$has_title_enabled = true; // in_array('title', $view_mode_displayed_metadata); -- Set to true as it would only work in the repository level
		$has_description_enabled = in_array('description', $view_mode_displayed_metadata);
		$has_meta = isset($view_mode_displayed_metadata['meta']) && count($view_mode_displayed_metadata['meta']) > 0;

		$collection_id_works = get_theme_mod('filefestival_tainacan_single_item_template_works', '');
		$collection_id_participants = get_theme_mod('filefestival_tainacan_single_item_template_participants', '');
		$collection_id_events = get_theme_mod('filefestival_tainacan_single_item_template_events', '');
		$collection_id_activities = get_theme_mod('filefestival_tainacan_single_item_template_activities', '');
		$collection_id_publications = get_theme_mod('filefestival_tainacan_single_item_template_publications', '');
		$collection_id_places = get_theme_mod('filefestival_tainacan_single_item_template_places', '');
	?>
	<ul class="tainacan-filefestival-list-container">

		<?php $item_index = 0; while ( have_posts() ) : the_post(); ?>
			<li class="tainacan-filefestival-list-item">

				<?php if ( $has_thumbnail_enabled ) : ?>
					<?php if ( has_post_thumbnail() ) : ?>
						<a 
								href="<?php echo get_item_link_for_navigation(get_permalink(), $item_index); ?>"
								class="filefestival-list-item-thumbnail">
							<?php the_post_thumbnail( 'tainacan-medium' ); ?>
							<div class="skeleton"></div> 
						</a>
					<?php else : ?>
						<a 
								href="<?php echo get_item_link_for_navigation(get_permalink(), $item_index); ?>"
								class="filefestival-list-item-thumbnail">
							<?php echo '<img alt="', esc_attr_e('Minatura da imagem do item', 'filefestival'), '" src="', esc_url(get_stylesheet_directory_uri()), '/images/thumbnail_placeholder.png">'?>
							<div class="skeleton"></div> 
						</a>
					<?php endif; ?>
				<?php endif; ?>

				<div class="tainacan-filefestival-list-item--metadata">
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
						<a 
								href="<?php echo get_item_link_for_navigation(get_permalink(), $item_index); ?>"
								class="<?php echo $title_class; ?>">
							<h3 class="metadata-label"><?php echo __('Título', 'filefestival'); ?></h3>
							<p class="metadata-value"><?php echo get_the_title(); ?></p>
						</a>
					<?php endif; if ( $is_repository_level && $has_description_enabled ): ?>
						<div class="metadata-type-core_description">
							<h3 class="metadata-label"><?php echo __('Descrição', 'filefestival'); ?></h3>
							<p class="metadata-value"><?php echo get_the_excerpt(); ?></p>
						</div>
					<?php endif; ?>
					<?php if ( $has_meta ) {
							tainacan_the_metadata(
								array(
									'exclude_title' => true,
									'metadata__in' => $view_mode_displayed_metadata['meta'],
									'before_title' => '<h3 class="metadata-label">',
									'before_value' => '<p class="metadata-value">',
									'after_title'  => '</h3>',
									'after_value'  => '</p>',
									'hide_empty'   => false,
									'empty_value_message' => ' - '
								)
							);
						}
					?>
				</div>
			</li>
		
		<?php $item_index++; endwhile; ?>
	
	</ul>

<?php else : ?>
	<div class="tainacan-filefestival-list-container">
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
