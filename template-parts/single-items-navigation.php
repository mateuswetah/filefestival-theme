<?php 

    // Building query to fetch items related to this via a taxonomy
    $related_taxonomies = get_post_taxonomies();
    $items_in_common = [];

    if ( $related_taxonomies && count($related_taxonomies) > 0 ) {
        
        foreach( $related_taxonomies as $related_taxonomy ) {
            $terms = [];
            $terms = get_the_terms($post, $related_taxonomy);

            if ( $terms && count($terms) > 0 ) {
                $tax_query = array();

                foreach( $terms as $term ) {
                    $tax_query[] = array(
                        'taxonomy' => $related_taxonomy,
                        'field' => 'slug',
                        'terms' => $term->slug,
                        'relation' => 'OR'
                    );
                }

                if ( count($tax_query) > 0 ) {

                    $args = array(
                        'posts_per_page' => 2,
                        'taxquery' => $tax_query,
                        'post__not_in' => [ $post->ID ],
                        'orderby' => 'rand'
                    );

                    $items_repository = \Tainacan\Repositories\Items::get_instance();

                    $items_in_common = $items_repository->fetch($args, [], 'OBJECT');
                }
                
                if ( $items_in_common && count($items_in_common) > 0 )
                    break;
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
        <?php if ( $items_in_common && count($items_in_common) > 0 ) : ?>
            <div class="items-in-common">
                <h2 class="tainacan-metadatum-label"><?php echo __('Veja também:', 'filefestival') ?></h2>
                <?php foreach( $items_in_common as $item_in_common ) : $common_item_id = $item_in_common->get_ID(); ?>
                    <a href="<?php echo get_the_permalink( $common_item_id ) ?>" class="item-in-common">
                        <?php
                            if ( has_post_thumbnail( $common_item_id ) ) {
                                echo get_the_post_thumbnail($common_item_id , 'tainacan-medium-large' );
                            } else {
                                $media_type = $item_in_common->get_document_mimetype();
                                echo '<img src="' . tainacan_get_the_mime_type_icon($media_type, 'tainacan-medium-large') . '" />';
                            }
                        ?>
                        <?php echo get_the_title( $common_item_id ); ?>
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