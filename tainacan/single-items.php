<?php get_header(); ?>

<?php
    $attachments = [];
    $attachments = tainacan_get_the_attachments();
    $document_type = tainacan_get_the_document_type();

    $section_classes = 'alignwide tainacan-item-single-content';

    if ( count($attachments) > 0)
        $section_classes .= ' has-attachments';
    
    if ( $document_type == 'empty')
        $section_classes .= ' has-empty-document ';

    $metadata = tainacan_get_the_metadata( [
        'before_title' => '<h2 class="tainacan-metadatum-label">',
        'after_title' => '</h2>',
        'before_value' => '<p class="tainacan-metadatum-value">',
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
                    
                        <?php if ( $document_type == 'empty' && has_post_thumbnail() ): ?>
                            <div class="tainacan-item-thumbnail">
                                <?php the_post_thumbnail('tainacan-medium-full'); ?>
                            </div>
                        <?php endif; ?>

                        <?php echo $metadata; ?>

                    </div>

                    <div class="tainacan-item-single-content--gallery">

                        <?php get_template_part( 'template-parts/single-items-gallery' ); ?>
                    
                    </div>

                    <div class="tainacan-item-single-content--information-2">
  
                        <?php echo $metadata; ?>

                    </div>

                    <div class="tainacan-item-single-content--navigation">
                        
                        <?php get_template_part( 'template-parts/single-items-navigation' ); ?>

                    </div>

                </section>
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


<?php get_footer(); ?>