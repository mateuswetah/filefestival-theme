<?php if ( have_posts() ) : ?>
	<ul class="tainacan-filefestival-list-container">

		<?php while ( have_posts() ) : the_post(); ?>
			
			<li class="tainacan-filefestival-list-item">
				<?php if ( has_post_thumbnail() ) : ?>
					<a 
							href="<?php the_permalink(); ?>"
							style="background-image: url(<?php the_post_thumbnail_url( 'tainacan-medium' ) ?>)"
							class="filefestival-list-item-thumbnail">
						<?php the_post_thumbnail( 'tainacan-medium' ); ?>
						<div class="skeleton"></div> 
					</a>
				<?php else : ?>
					<a 
							href="<?php the_permalink(); ?>"
							class="filefestival-list-item-thumbnail">
						<?php echo '<img alt="', esc_attr_e('Minatura da imagem do item', 'filefestival'), '" src="', esc_url(get_stylesheet_directory_uri()), '/images/thumbnail_placeholder.png">'?>
						<div class="skeleton"></div> 
					</a>
				<?php endif; ?>
				<?php
					tainacan_the_metadata(
						array(
							'metadata__in' => $view_mode_displayed_metadata['meta'],
							'before_title' => '<h3 class="metadata-label">',
							'before_value' => '<p class="metadata-value">',
							'after_title'  => '</h3>',
							'after_value'  => '</p>'
						)
					);
				?>
			</li>
		
		<?php endwhile; ?>
	
	</ul>

<?php else : ?>
	<div class="tainacan-filefestival-list-container">
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
