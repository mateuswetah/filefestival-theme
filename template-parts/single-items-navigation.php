<?php 

    // Variables from single-items.php template
    $metadata_objects = isset($args['metadata_objects']) ? $args['metadata_objects'] : []; 
    $is_works_collection = isset($args['is_works_collection']) ? $args['is_works_collection'] : false;
    $is_participants_collection = isset($args['is_participants_collection']) ? $args['is_participants_collection'] : false;
    $is_events_collection = isset($args['is_events_collection']) ? $args['is_events_collection'] : false;
    $is_activities_collection = isset($args['is_activities_collection']) ? $args['is_activities_collection'] : false;
    $is_publications_collection = isset($args['is_publications_collection']) ? $args['is_publications_collection'] : false; 

    // Building query to fetch items related to this via relationships
    $relationship_metadata_objects = array_filter($metadata_objects, function($metadatum_object) {
        return $metadatum_object && $metadatum_object->get_metadata_type() == 'Tainacan\Metadata_Types\Relationship';
    });
    $related_items_id = [];
    $related_items_object = [];
    
    if ( $relationship_metadata_objects && count($relationship_metadata_objects) > 0 ) {
        
        // For most collections, we get the first relationship metadata that has values
        foreach( $relationship_metadata_objects as $relationship_metadatum_object ) {
            $item_metadata_repository = new \Tainacan\Entities\Item_Metadata_Entity(tainacan_get_item(), $relationship_metadatum_object);
            echo '<div style="display: none; visibility:hidden;">' . $relationship_metadatum_object->get_name() . ': ' . json_encode($item_metadata_repository->get_value()) . '</div>';
            if ( !$item_metadata_repository->has_value() )
                continue;
            else {
                if ( !$item_metadata_repository->is_multiple() )
                    $related_items_id[] = $item_metadata_repository->get_value();
                else {
                    
                    $related_items_ids = $item_metadata_repository->get_value();
                    
                    foreach($related_items_ids as $a_related_item_id) {
                        $related_items_id[] = $a_related_item_id;
                    }
                }
            }

        }
        
        // Fetching the related items 
        if ( count($related_items_id) > 0 ) {
            $related_query = array(
                'posts_per_page' => 2,
                'post__in' => $related_items_id,
                'order_by' => 'post__in'
            );
            $items_repository = \Tainacan\Repositories\Items::get_instance();
            $related_items_object = $items_repository->fetch($related_query, [], 'OBJECT');
        }
        
        // Some collections also search for items related to a certain related item
        $more_related_items_object = [];
        if (
            ( $is_works_collection || $is_activities_collection || $is_publications_collection ) &&
            count($related_items_object) > 0 &&
            $related_items_object[0] instanceof \Tainacan\Entities\Item
        ) {

            $items_related_to_this = $related_items_object[0]->get_related_items();
            if ( $items_related_to_this && count($items_related_to_this) > 0 ) {
                
                foreach( $items_related_to_this as $items_related_to_this_group ) {
                    
                    if ( isset($items_related_to_this_group['total_items']) && $items_related_to_this_group['total_items'] == 0)
                        continue;

                    if ( $items_related_to_this_group['items'] && count($items_related_to_this_group['items']) > 0 ) {

                        $items_related_to_this_group['items'] = array_filter($items_related_to_this_group['items'], function($a_related_item) {
                            return isset($a_related_item['id']) && $a_related_item['id'] !== get_the_ID();
                        });
                        $more_related_items_object = array_merge($more_related_items_object, $items_related_to_this_group['items']);
                    }

                    if ( count($more_related_items_object) >= 1 )
                        break;
                }
                
            }
        }
        
        // We only add more related items after displaying at least one of the initial relations
        if ( count($more_related_items_object) > 0 && isset($more_related_items_object[0]['id']) ) {
            $item = new \Tainacan\entities\Item($more_related_items_object[0]['id']);

            if ( $item instanceof \Tainacan\Entities\Item ) {
                if (count($related_items_object) === 1)
                    $related_items_object[] = $item;

                if (count($related_items_object) > 1)
                    $related_items_object[1] = $item;
            }
        }
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