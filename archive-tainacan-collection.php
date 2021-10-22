<?php
/**
 * The template for displaying tainacan collections
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();

//$description = get_the_archive_description();
$description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';
?>

<?php if ( have_posts() ) : ?>
    <div class="entry-content">
        <section class="tainacan-collections alignwide">
            <header class="page-header alignwide">
                <h1 class="page-title"><?php echo __('FILE Arquivo', 'filefestival') ; ?></h1>
                <?php if ( $description ) : ?>
                    <div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
                <?php endif; ?>
                <div class="tainacan-collections-control">
                    <div
                            class="field is-horizontal"
                            id="collections-layout-select">
                        <div class="field-label">
                            <label class="label"><?php echo __('visualização', 'filefestival') ; ?>:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <span class="select">
                                        <select
                                                onchange="
                                                    document.body.classList.remove('collections-list-layout-lista');
                                                    document.body.classList.remove('collections-list-layout-grade');
                                                    document.body.classList.add('collections-list-layout-' + this.value);
                                                "
                                                onload="
                                                    document.body.classList.remove('collections-list-layout-lista');
                                                    document.body.classList.remove('collections-list-layout-grade');
                                                    document.body.classList.add('collections-list-layout-' + this.value);
                                                "
                                                aria-controls="tainacan-collections-list"
                                                aria-labelledby="collections-layout-select">
                                            <option selected value="grade">
                                                Grade &nbsp;
                                            </option>
                                            <option value="lista">
                                                Lista &nbsp;
                                            </option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header><!-- .page-header -->
            
            <div class="tainacan-collections-list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <a 
                            id="<?php echo 'tainacan-collection-' . get_the_ID() ?>"
                            href="<?php echo get_post_permalink(); ?>"
                            class="tainacan-collection">
                        <div class="tainacan-collection__thumbnail">
                            <?php if ( has_post_thumbnail() ) {
                                the_post_thumbnail();
                            } else {
                                echo '<img alt="', esc_attr_e('Minatura da imagem da coleção', 'filefestival'), '" src="', esc_url(get_stylesheet_directory_uri()), '/images/thumbnail_placeholder.png">';
                            }
                            ?>
                        </div>
                        <div class="tainacan-collection__title">
                            <h2><?php the_title(); ?></h2>  
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <?php twenty_twenty_one_the_posts_navigation(); ?>
            
        </section>
    </div>
<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
