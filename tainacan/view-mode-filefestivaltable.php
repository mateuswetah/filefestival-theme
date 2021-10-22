<?php if ( have_posts() ) : ?>
	<?php 
		$metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
		$metadata_objects = [];
		$is_repository_level = !isset($request['collection_id']);
		$has_title_enabled = in_array('title', $view_mode_displayed_metadata);
		$has_description_enabled = in_array('description', $view_mode_displayed_metadata);
		$has_meta = isset($view_mode_displayed_metadata['meta']) && count($view_mode_displayed_metadata['meta']) > 0;

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
					<?php if ( $is_repository_level ): ?>
						<?php if ( $has_title_enabled ): ?>
							<th class="tainacan-text--title"><?php echo __('Título', 'filefestival'); ?></th>
						<?php endif; if ( $has_description_enabled ) :?>
							<th class="tainacan-textarea"><?php echo __('Descrição', 'filefestival'); ?></th>
						<?php endif; ?>
					<?php endif; ?>
					<?php foreach($metadata_objects as $metadatum): 
							$metadatum_component = '';
							$metadatum_object = $metadatum->get_metadata_type_object()->_toArray();
							$metadatum_component = $metadatum_object['component'];
						?>
						<th class="<?php echo $metadatum_component; ?>"><?php echo $metadatum->get_name(); ?> </th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<tr class="tainacan-filefestival-table-item">
					<?php if ( $is_repository_level && $has_title_enabled ): ?>
						<td class="metadata-type-core_title"><p class="metadata-value"><?php echo get_the_title(); ?></p></td>
					<?php endif; if ( $is_repository_level && $has_description_enabled ): ?>
						<td class="metadata-type-core_description"><p class="metadata-value"><?php echo get_the_excerpt(); ?></p></td>
					<?php endif; ?>
					<?php if ( $has_meta ) {
							tainacan_the_metadata(array(
								'metadata__in' => $view_mode_displayed_metadata['meta'],
								'before_title' => '<h3 class="metadata-label">',
								'before_value' => '<p class="metadata-value">',
								'after_title'  => '</h3>',
								'after_value'  => '</p>',
								'before' => '<td class="metadata-type-$type" $id>',
								'after' => '</td>',
								'hide_empty' => false,
								//'empty_value_message' => '<span class="empty-metadata-value">' . __('Informação não fornecida.', 'filefestival') . '</span>',
								'empty_value_message' => ' - '
							));
						} 
					?>
				</tr>
			
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>

<?php else : ?>
	<div class="tainacan-filefestival-table-container">
		<section class="section">
			<div class="content has-text-gray4 has-text-centered">
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
