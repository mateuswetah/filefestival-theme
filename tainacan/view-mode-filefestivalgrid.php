<?php
    $is_slideshow_available = false;
    if (function_exists('tainacan_is_view_mode_enabled'))
        $is_slideshow_available = tainacan_is_view_mode_enabled('slideshow');
?> 

<?php if ( have_posts() ) : ?>
	<div class="tainacan-filefestival-grid-container">

		<?php $item_index = 0; while ( have_posts() ) : the_post(); ?>
			
			<div class="tainacan-filefestival-grid-item">
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
					<?php if ( $is_slideshow_available ) : ?>
						<a href="?<?php echo $_SERVER['QUERY_STRING'] ?>&slideshow-from=<?php echo $item_index ?>" class="icon slideshow-icon">
							<i class="tainacan-icon tainacan-icon-viewgallery tainacan-icon-1-125em"></i>
						</a>
					<?php endif; ?> 
				</div>
			</div>	
		
		<?php $item_index++; endwhile; ?>
	
	</div>

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
