<?php get_header(); ?>

<div id="content" class="site-content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php if ( have_posts() ) : ?>

                <article id="post-<?php the_ID()?>" class="post-<?php the_ID()?> page type-page status-publish hentry entry">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <div class="entry-content">

                            <section class="alignwide ">

                                <div class="single-item-collection--information justify-content-center">
                                    <div class="tainacan-metadata-list">
                                    
                                    <?php do_action( 'filefestival-tainacan-single-item-metadata-begin' ); ?>
                                    
                                        <?php
                                            $args = array(
                                                'before_title' => '<div class="tainacan-item-metadatum"><h1>',
                                                'after_title' => '</h1>',
                                                'before_value' => '<p>',
                                                'after_value' => '</p></div>',
                                            );
                                            tainacan_the_metadata( $args );
                                        ?>
                                        <?php do_action( 'filefestival-tainacan-single-item-metadata-end' ); ?>
                                    </div>
                                </div>
                            </section>
                        
                            <?php do_action( 'filefestival-tainacan-single-item-after-metadata' ); ?>

                            <?php if ( tainacan_has_document() ) : ?>
                                <section class="alignwide">
                                    <div class="single-item-collection--document">
                                        <?php tainacan_the_document(); ?>
                                    </div>
                                </section>
                            <?php endif; ?>
                    
                        <?php do_action( 'filefestival-tainacan-single-item-after-document' ); ?>

                            <?php
                                if (function_exists('tainacan_get_the_attachments')) {
                                    $attachments = tainacan_get_the_attachments();
                                } else {
                                    // compatibility with pre 0.11 tainacan plugin
                                    $attachments = array_values(
                                        get_children(
                                            array(
                                                'post_parent' => $post->ID,
                                                'post_type' => 'attachment',
                                                'post_mime_type' => 'image',
                                                'order' => 'ASC',
                                                'numberposts'  => -1,
                                            )
                                        )
                                    );
                                }
                            ?>

                            <?php if ( ! empty( $attachments ) ) : ?>
                                <hr>
                                <section class="alignwide">
                                    <h2 class="title-content-items">Anexos</h2>
                                    <div class="single-item-collection--attachments">
                                        <?php foreach ( $attachments as $attachment ) { ?>
                                            <?php
                                            if ( function_exists('tainacan_get_attachment_html_url') ) {
                                                $href = tainacan_get_attachment_html_url($attachment->ID);
                                            } else {
                                                $href = wp_get_attachment_url($attachment->ID, 'large');
                                            }
                                            ?>
                                            <div class="single-item-collection--attachments-file">
                                                <a 
                                                    class="<?php if (!wp_get_attachment_image( $attachment->ID, 'filefestival-tainacan-item-attachments')) echo'attachment-without-image'; ?>"
                                                    href="<?php echo $href; ?>" data-toggle="lightbox" data-gallery="example-gallery">
                                                    <?php
                                                        echo wp_get_attachment_image( $attachment->ID, 'filefestival-tainacan-item-attachments', true );
                                                        echo get_the_title( $attachment->ID );
                                                    ?>
                                                </a>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </section>
                            <?php endif; ?>
                            
                        </div><!-- .entry-content -->

                        <footer class="entry-footer">
                            <?php if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif; ?>
                        </footer>

                    <?php endwhile; ?>

                </article><!-- #post-151666 -->

            <?php else : ?>
                Nada encontrado aqui.
            <?php endif; ?>
            
        </main><!-- #main -->
    </div><!-- #primary -->
</div>

<?php get_footer(); ?>