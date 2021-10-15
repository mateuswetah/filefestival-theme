<?php if ( have_posts() ) : ?>
	<?php 
		$metadata_labels = [];
		$metadata_repository = \Tainacan\Repositories\Metadata::get_instance();

		$metadata_objects = $metadata_repository->fetch([ 'post__in' => $view_mode_displayed_metadata['meta'] ],	'OBJECT');
		
		$metadata_labels = array_map(function($metadatum_object) {
			return $metadatum_object->get_name();
		}, $metadata_objects);
	?>
	<div class="tainacan-filefestival-table-container">
		<table class="tainacan-filefestival-table-container-table">
			<thead>
				<tr>
					<?php foreach($metadata_labels as $metadatum) { echo '<th>' . $metadatum . '</th>'; } ?>
				</tr>
			</thead>
			<tbody>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<tr class="tainacan-filefestival-table-item">
					<?php
						tainacan_the_metadata(
							array(
								'metadata__in' => $view_mode_displayed_metadata['meta'],
								'before_title' => '<h3 class="metadata-label">',
								'before_value' => '<p class="metadata-value">',
								'after_title'  => '</h3>',
								'after_value'  => '</p>',
								'before' => '<td class="metadata-type-$type" $id>',
								'after' => '</td>'
							)
						);
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
