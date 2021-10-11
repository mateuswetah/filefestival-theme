<?php if ( have_posts() ) : ?>
	<?php $view_mode_displayed_metadata['meta'][0]; ?>
	<table class="tainacan-filefestival-table-container">
		<thead>
			<tr>
				<?php foreach($view_mode_displayed_metadata['meta'] as $metadatum) { echo '<th>' . $metadatum . '</th>'; } ?>
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