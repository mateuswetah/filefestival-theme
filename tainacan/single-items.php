<?php get_header(); ?>

<?php
    $collection = tainacan_get_collection();
    $is_works_collection = get_theme_mod('filefestival_tainacan_single_item_template_works', '') == $collection->get_ID();
    $is_participants_collection = get_theme_mod('filefestival_tainacan_single_item_template_participants', '') == $collection->get_ID();
    $is_events_collection = get_theme_mod('filefestival_tainacan_single_item_template_events', '') == $collection->get_ID();

    $attachments = [];
    $attachments = tainacan_get_the_attachments();

    $section_classes = 'alignwide tainacan-item-single-content';
    $section_classes .= $is_works_collection ? ' is-works-collection ' : '';
    $section_classes .= $is_participants_collection ? ' is-participants-collection ' : '';
    $section_classes .= $is_events_collection ? ' is-events-collection ' : '';
    $section_classes .= count($attachments) > 0 ? ' has-attachments ' : '';

    $metadata = tainacan_get_the_metadata( [
        'before_title' => '<h2 class="tainacan-metadatum-label">',
        'after_title' => '</h2>',
        'before_value' => '<p class="tainacan-metadatum-value" data-tippy-content>',
        'after_value' => '</p>',
        'before' => '<div class="metadata-type-$type" $id>',
        'after' => '</div>'
     ] );
?>

<?php if ( have_posts() ) : ?>

    <article id="post-<?php the_ID()?>" class="post-<?php the_ID()?> page type-page status-publish hentry entry">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="entry-content">

                <section class="<?php echo $section_classes; ?>">

                    <h1 class="screen-reader-text">
                        <?php the_title() ?>
                    </h1>

                    <div class="tainacan-item-single-content--information">
                    
                        <?php if ( $is_participants_collection && has_post_thumbnail() ): ?>
                            <div class="tainacan-item-thumbnail">
                                <?php the_post_thumbnail('tainacan-medium-full'); ?>
                            </div>
                        <?php endif; ?>

                        <?php echo $metadata; ?>

                    </div>

                    <?php if ( !$is_participants_collection ): ?>
                        <div class="tainacan-item-single-content--gallery">

                            <?php get_template_part( 'template-parts/single-items-gallery' ); ?>
                        
                        </div>
                    <?php endif; ?>

                    <div class="tainacan-item-single-content--information-2">
  
                        <?php echo $metadata; ?>

                        <?php 
                            if ( $is_events_collection ) {

                                // Then fetches related ones
                                try {
                                    $item = new \Tainacan\entities\Item(get_the_ID());

                                    if ( $item instanceof \Tainacan\Entities\Item ) {
                                        $related_items = $item->get_related_items();

                                        if ( count($related_items) > 0 ): ?>
                                            <div class="metadata-items-related-to-this">
                                                <h2 class="tainacan-metadatum-label"><?php echo __('Mais informações deste evento', 'filefestival'); ?></h2>
                                                <p class="tainacan-metadatum-value">
                                                <?php 
                                                    $related_links = [];
                                                    foreach($related_items as $collection_id => $related_group) {
                                                        if (
                                                            isset($related_group['total_items']) &&
                                                            isset($related_group['collection_slug']) &&
                                                            isset($related_group['collection_name']) &&
                                                            $related_group['total_items'] > 0
                                                        ) {
                                                            ob_start();
                                                            ?>
                                                                <a href="<?php echo '/' . $related_group['collection_slug'] . '?metaquery[0][key]=' . $related_group['metadata_id'] . '&metaquery[0][value][0]=' . $item->get_ID() . '&metaquery[0][compare]=IN'; ?>">
                                                                    <?php echo $related_group['collection_name'] . ' (' . $related_group['total_items'] . ')'; ?>
                                                                </a>
                                                            <?php
                                                            $related_links[] = ob_get_contents();
                                                            ob_end_clean();
                                                        }
                                                    }
                                                    echo implode($related_links, ' <span class="multivalue-separator"> | </span>');
                                                ?>
                                                </p>
                                            </div>
                                    
                                        <?php endif;
                                    }
                                } catch (Exception $error) {
                                    echo '';
                                }
                            } 
                        ?>

                    </div>

                    <div class="tainacan-item-single-content--navigation">
                        
                        <?php get_template_part( 'template-parts/single-items-navigation' ); ?>

                    </div>

                </section>
            </div><!-- .entry-content -->

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <footer class="entry-footer">
                    <?php comments_template(); ?>
                </footer>
            <?php endif; ?>

        <?php endwhile; ?>

    </article><!-- #post-ID -->

<?php 
    else:
        echo __( 'Nada encontrado aqui.', 'filefestival'); 
    endif;
?>


<?php get_footer(); ?>