<?php 

    // Building query to fetch items related to this via relationships
    $metadata_objects = isset($args['metadata_objects']) ? $args['metadata_objects'] : []; 
    $relationship_metadata_objects = array_filter($metadata_objects, function($metadatum_object) {
        return $metadatum_object && $metadatum_object->get_metadata_type() == 'Tainacan\Metadata_Types\Relationship';
    });
    
    $related_items_id = [];
    $related_items_object = [];

    if ( $relationship_metadata_objects && count($relationship_metadata_objects) > 0 ) {
        
        foreach( $relationship_metadata_objects as $relationship_metadatum_object ) {
            $item_metadata_repository = new \Tainacan\Entities\Item_Metadata_Entity(tainacan_get_item(), $relationship_metadatum_object);
            
            if ( !$item_metadata_repository->has_value() )
                continue;
            else {
                if ( !$item_metadata_repository->is_multiple() )
                    $related_items_id[] = $item_metadata_repository->get_value();
                else {
                    
                    $related_items_ids = $item_metadata_repository->get_value();
                    
                    foreach($related_items_ids as $a_related_item_html) {
                        $related_items_id[] = $a_related_item_html;
                    }
                }
            }
        }

        $args = array(
            'posts_per_page' => 2,
            'post__in' => $related_items_id,
            'orderby' => 'post__in'
        );

        $items_repository = \Tainacan\Repositories\Items::get_instance();
        $related_items_object = $items_repository->fetch($args, [], 'OBJECT');
    }
    
    // Next and Previous Items
    $adjacent_links = [
        'next' => '',
        'previous' => ''
    ];

    $adjacent_links = tainacan_get_adjacent_item_links();

    $previous = $adjacent_links['previous'];
    $next = $adjacent_links['next'];
?>
<?php if ($previous !== '' || $next !== '') : ?>

    <div class="tainacan-single-navigation-links">
        <?php if ( $related_items_object && count($related_items_object) > 0 ) : ?>
            <div class="items-in-common">
                <h2 class="tainacan-metadatum-label"><?php echo __('Veja também:', 'filefestival') ?></h2>
                <?php foreach( $related_items_object as $related_item ) : $related_item_id = $related_item->get_ID(); ?>
                    <a href="<?php echo get_the_permalink( $related_item_id ) ?>" class="item-in-common">
                        <?php
                            if ( has_post_thumbnail( $related_item_id ) ) {
                                echo get_the_post_thumbnail($related_item_id , 'tainacan-medium-large' );
                            } else {
                                $media_type = $related_item->get_document_mimetype();
                                echo '<img src="' . tainacan_get_the_mime_type_icon($media_type, 'tainacan-medium-large') . '" />';
                            }
                        ?>
                        <?php echo get_the_title( $related_item_id ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="related-pages">
            <a class="tainacan-single-navigation-links--list" href="<?php echo tainacan_get_source_item_list_url(); ?>">
                <svg version="1.1" viewBox="0 0 42.621 21.621" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><g transform="matrix(1.3333 0 0 -1.3333 0 21.621)"><path class="cls-1" transform="matrix(.75 0 0 -.75 0 16.216)" d="m0-0.0019531v1.5 13.5h36.883l-3.4434 3.4414-1.0625 1.0586 2.123 2.123 8.123-8.123-7.0625-7.0586-1.0605-1.0605-2.123 2.1191 4.5 4.5h-33.877v-10.5-1.5h-3z" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1.3333" /></g></svg><span><?php echo __('Voltar para a lista', 'filefesival') ?></span>
            </a>
            <?php echo $previous; ?>
            <?php echo $next; ?>
        </div>
    </div>
<?php endif; ?>