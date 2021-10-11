<?php if ( have_posts() ) : ?>
	<ul class="tainacan-filefestival-grid-container">

		<?php $item_index = 0; while ( have_posts() ) : the_post(); ?>
			
			<li class="tainacan-filefestival-grid-item">
				<?php if ( has_post_thumbnail() ) : ?>
					<a 
							href="<?php the_permalink(); ?>"
							style="background-image: url(<?php the_post_thumbnail_url( 'tainacan-medium' ) ?>)"
							class="filefestival-grid-item-thumbnail">
						<?php the_post_thumbnail( 'tainacan-medium' ); ?>
						<div class="skeleton"></div> 
					</a>
				<?php else : ?>
					<a 
							href="<?php the_permalink(); ?>"
							class="filefestival-grid-item-thumbnail">
						<?php echo '<img alt="', esc_attr_e('Minatura da imagem do item', 'filefestival'), '" src="', esc_url(get_stylesheet_directory_uri()), '/images/thumbnail_placeholder.png">'?>
						<div class="skeleton"></div> 
					</a>
				<?php endif; ?>
				<div class="metadata-title">
					<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
				</div>
			</li>	
		
		<?php $item_index++; endwhile; ?>
	
	</ul>

<?php else : ?>
	<div class="tainacan-filefestival-grid-container">
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
