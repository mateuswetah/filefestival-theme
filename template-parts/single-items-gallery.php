<?php

$attachments = tainacan_get_the_attachments();
$is_gallery_mode = true;
$hide_file_name = false;
$hide_file_caption = false;
$hide_file_description = true;
$disable_gallery_lightbox = false;

if ( !empty( $attachments )  || tainacan_has_document() ) : ?>

    <?php 

        $media_items_thumbs = array();
        $media_items_main = array();

        if ($is_gallery_mode) {

            $class_slide_metadata = '';
            if ($hide_file_name)
                $class_slide_metadata .= ' hide-name';
            if ($hide_file_description)
                $class_slide_metadata .= ' hide-description';
            if ($hide_file_caption)
                $class_slide_metadata .= ' hide-caption';

            if ( tainacan_has_document() ) {
                $is_document_type_attachment = tainacan_get_the_document_type() === 'attachment';
                $media_items_main[] =
                    tainacan_get_the_media_component_slide(array(
                        'media_content' => tainacan_get_the_document(),
                        'media_content_full' => $is_document_type_attachment ? tainacan_get_the_document(0, 'full') : ('<div class="attachment-without-image">' . tainacan_get_the_document(0, 'full') . '</div>'),
                        'media_title' => $is_document_type_attachment ? get_the_title(tainacan_get_the_document_raw()) : '',
                        'media_description' => $is_document_type_attachment ? get_the_content(tainacan_get_the_document_raw()) : '',
                        'media_caption' => $is_document_type_attachment ? wp_get_attachment_caption(tainacan_get_the_document_raw()) : '',
                        'media_type' => tainacan_get_the_document_type(),
                        'class_slide_metadata' => $class_slide_metadata
                    ));
            }
            
            foreach ( $attachments as $attachment ) {
                $media_items_main[] =
                    tainacan_get_the_media_component_slide(array(
                        'media_content' => tainacan_get_attachment_as_html($attachment->ID, 0),
                        'media_content_full' => wp_attachment_is('image', $attachment->ID) ? wp_get_attachment_image( $attachment->ID, 'full', false) : ('<div class="attachment-without-image tainacan-embed-container"><iframe id="tainacan-attachment-iframe" src="' . tainacan_get_attachment_html_url($attachment->ID) . '"></iframe></div>'),
                        'media_title' => $attachment->post_title,
                        'media_description' => $attachment->post_content,
                        'media_caption' => $attachment->post_excerpt,
                        'media_type' => $attachment->post_mime_type,
                        'class_slide_metadata' => $class_slide_metadata
                    ));
            }
        }
        if ( 
            (tainacan_has_document() && $attachments && sizeof($attachments) > 0 ) ||
            (!tainacan_has_document() && $attachments && sizeof($attachments) > 1 ) 
        ) {
            if ( tainacan_has_document() ) {
                $is_document_type_attachment = tainacan_get_the_document_type() === 'attachment';
                $media_items_thumbs[] =
                    tainacan_get_the_media_component_slide(array(
                        'media_content' => get_the_post_thumbnail(null, 'tainacan-medium'),
                        'media_content_full' => $is_document_type_attachment ? tainacan_get_the_document(0, 'full') : ('<div class="attachment-without-image">' . tainacan_get_the_document(0, 'full') . '</div>'),
                        'media_title' => $is_document_type_attachment ? get_the_title(tainacan_get_the_document_raw()) : '',
                        'media_description' => $is_document_type_attachment ? get_the_content(tainacan_get_the_document_raw()) : '',
                        'media_caption' => $is_document_type_attachment ? wp_get_attachment_caption(tainacan_get_the_document_raw()) : '',
                        'media_type' => tainacan_get_the_document_type(),
                        'class_slide_metadata' => 'hide-caption hide-description ' . ( get_theme_mod('tainacan_single_item_hide_files_name', false) ? 'hide-name' : '' )
                    ));
                
            }
            foreach ( $attachments as $attachment ) {
                $media_items_thumbs[] = 
                    tainacan_get_the_media_component_slide(array(
                        'media_content' => wp_get_attachment_image( $attachment->ID, 'tainacan-medium', false ),
                        'media_content_full' => wp_attachment_is('image', $attachment->ID) ? wp_get_attachment_image( $attachment->ID, 'full', false) : ('<div class="attachment-without-image tainacan-embed-container"><iframe id="tainacan-attachment-iframe" src="' . tainacan_get_attachment_html_url($attachment->ID) . '"></iframe></div>'),
                        'media_title' => $attachment->post_title,
                        'media_description' => $attachment->post_content,
                        'media_caption' => $attachment->post_excerpt,
                        'media_type' => $attachment->post_mime_type,
                        'class_slide_metadata' => 'hide-caption hide-description ' . ( get_theme_mod('tainacan_single_item_hide_files_name', false) ? 'hide-name' : '' )
                    ));
            }
        }
        tainacan_the_media_component(
            'tainacan-item-attachments_id-' . $post->ID,
            null,
            $is_gallery_mode ? $media_items_main : null,
            array(
                'class_main_div' => '',
                'class_thumbs_div' => '',
                'show_share_button' => true,
                'fullscreelEl' => false,
                'swiper_thumbs_options' => $is_gallery_mode ? 
                    array(
                        'slidesPerView' => 'auto',
                        'spaceBetween' => 45,
                        'autoHeight' => true
                    ) : array(
                    'navigation' => array(
                        'nextEl' => '.swiper-navigation-next_' . 'tainacan-item-attachments_id-' . $post->ID . '-thumbs',
                        'prevEl' => '.swiper-navigation-prev_' . 'tainacan-item-attachments_id-' . $post->ID . '-thumbs',
                        'preloadImages' => false,
                        'lazy' => true
                    ),
                    'slidesPerView' => 'auto',
                    'spaceBetween' => 45,
                    'autoHeight' => true
                ),
                'swiper_main_options' => $is_gallery_mode ? array(
                    'navigation' => array(
                        'nextEl' => '.swiper-navigation-next_' . 'tainacan-item-attachments_id-' . $post->ID . '-main',
                        'prevEl' => '.swiper-navigation-prev_' . 'tainacan-item-attachments_id-' . $post->ID . '-main',
                        'preloadImages' => false,
                        'lazy' => true
                    ),
                    'slidesPerView' => 'auto',
                    'spaceBetween' => 45,
                    'autoHeight' => true
                ) : array(
                    'slidesPerView' => 'auto',
                    'spaceBetween' => 45,
                    'autoHeight' => true
                ),
            )
        );
    ?>

<?php endif; ?>
