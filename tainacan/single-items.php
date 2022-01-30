<?php get_header(); ?>

<?php
    $collection = tainacan_get_collection();
    $is_works_collection = get_theme_mod('filefestival_tainacan_single_item_template_works', '') == $collection->get_ID();
    $is_participants_collection = get_theme_mod('filefestival_tainacan_single_item_template_participants', '') == $collection->get_ID();
    $is_events_collection = get_theme_mod('filefestival_tainacan_single_item_template_events', '') == $collection->get_ID();
    $is_activities_collection = get_theme_mod('filefestival_tainacan_single_item_template_activities', '') == $collection->get_ID();
    $is_publications_collection = get_theme_mod('filefestival_tainacan_single_item_template_publications', '') == $collection->get_ID();

    $attachments = [];
    $attachments = tainacan_get_the_attachments();

    /* Fetch the URL type metadata to add to the carousel */
    $metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
    $URL_metadata_html = [];
    $URL_metadata_IDs = [];
    $max_URL_meta_to_add_to_carousel = 2;

    /* Getch metadata objects to use here and in the single-items-navigation.php */        
    $metadata_objects = $metadata_repository->fetch_by_collection(
        $collection,
        [
            'posts_per_page' => -1
        ],
        'OBJECT'
    );
    $metadata_objects = $metadata_repository->order_result($metadata_objects, $collection);

    if ($is_works_collection) {

        $URL_metadata_objects = array_filter($metadata_objects, function($metadatum_object) {
            return $metadatum_object && $metadatum_object->get_metadata_type() == 'TAINACAN_URL_Plugin_Metadata_Type';
        });
        if ( count($URL_metadata_objects) > $max_URL_meta_to_add_to_carousel )
            array_splice($URL_metadata_objects, $max_URL_meta_to_add_to_carousel);
    }
    if ( !empty($URL_metadata_objects) ) {

        foreach($URL_metadata_objects as $URL_metadatum) {
            $item_metadata_repository = new \Tainacan\Entities\Item_Metadata_Entity(tainacan_get_item(), $URL_metadatum);
            if ( !$item_metadata_repository->has_value() )
                continue;
            else {
                if ( !$item_metadata_repository->is_multiple() )
                    $URL_metadata_html[] = $item_metadata_repository->get_value_as_html();
                else {
                    
                    $URL_metadata_htmls = explode( $item_metadata_repository->get_multivalue_separator(), $item_metadata_repository->get_value_as_html() );
                    
                    foreach($URL_metadata_htmls as $a_URL_metadata_html)
                        $URL_metadata_html[] = $a_URL_metadata_html;
                }
                $URL_metadata_IDs[] = $URL_metadatum->get_ID();
            }
        }
    }
    
    $metadata = tainacan_get_the_metadata( [
        'metadata__not_in' => !empty($URL_metadata_IDs) ? $URL_metadata_IDs : null,
        'before_title' => '<h2 class="tainacan-metadatum-label">',
        'after_title' => '</h2>',
        'before_value' => '<p class="tainacan-metadatum-value" data-tippy-content>',
        'after_value' => '</p>',
        'before' => '<div class="metadata-type-$type" $id>',
        'after' => '</div>',
        'hide_empty' => !$is_works_collection,
        'empty_value_message' => ' - '
    ] );

    /* Sets several classes to customize layout via theme */
    $section_classes = 'alignwide tainacan-item-single-content';
    $section_classes .= $is_works_collection ? ' is-works-collection ' : '';
    $section_classes .= $is_participants_collection ? ' is-participants-collection ' : '';
    $section_classes .= $is_events_collection ? ' is-events-collection ' : '';
    $section_classes .= ( count($attachments) + count($URL_metadata_html) ) > 0 ? ' has-attachments ' : '';
?>

<?php if ( have_posts() ) : ?>

    <article id="post-<?php the_ID()?>" class="post-<?php the_ID()?> page type-page status-publish hentry entry">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="entry-content">

                <section class="<?php echo $section_classes; ?>">

                    <h1 class="screen-reader-text">
                        <?php the_title() ?>
                    </h1>

                    <?php if ( $is_participants_collection && has_post_thumbnail() ): ?>
                        <div class="tainacan-item-thumbnail">
                            <?php the_post_thumbnail('tainacan-medium-full'); ?>
                        </div>
                    <?php endif; ?>

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

                            <?php get_template_part( 'template-parts/single-items-gallery', null, [ 'attachments' => $attachments, 'URL_metadata_html' => $URL_metadata_html ] ); ?>
                        
                        </div>
                    <?php endif; ?>

                    <div class="tainacan-item-single-content--information-2">
  
                        <?php echo $metadata; ?>

                        <?php
                            // Then fetches related ones
                            try {
                                $item = new \Tainacan\entities\Item(get_the_ID());

                                if ( $item instanceof \Tainacan\Entities\Item ) {
                                    $related_items = $item->get_related_items();

                                    if ( $related_items && count($related_items) > 0 ): ?>
                                        <div class="metadata-items-related-to-this">
                                            <h2 class="tainacan-metadatum-label"><?php echo __('Mais informações', 'filefestival'); ?></h2>
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
                            
                        ?>

                    </div>

                    <div class="tainacan-item-single-content--navigation">
                        
                        <?php 
                            get_template_part(
                                'template-parts/single-items-navigation',
                                null,
                                array(
                                    'metadata_objects' => $metadata_objects,
                                    'is_works_collection' => $is_works_collection,
                                    'is_participants_collection' => $is_participants_collection,
                                    'is_events_collection' => $is_events_collection,
                                    'is_activities_collection' => $is_activities_collection,
                                    'is_publications_collection' => $is_publications_collection
                                )
                            );
                        ?>

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