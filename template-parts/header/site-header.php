<?php
/**
 * Displays the site header.
 *
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">

	<?php get_template_part( 'template-parts/header/site-branding' ); ?>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>

</header><!-- #masthead -->

<div class="mobile-subheader">
    <div
            class="wp-block-tainacan-search-bar is-style-default"
            data-module="search-bar">
        <div class="tainacan-search-container">
            <form 
                    id="tainacan-search-bar-block"
                    action="<?php echo (esc_url_raw( get_site_url() ) . '/' . \Tainacan\Theme_Helper::get_instance()->get_items_list_slug()); ?>"
                    data-queryparam="search"
                    method="get">
                <input
                        id="tainacan-search-bar-block_input"
                        label="<?php echo __('Busca', 'filefestival') ?>"
                        name="search"
                        placeholder="<?php echo __('Busca', 'filefestival') ?>...">
                <button
                        class="button"
                        type="submit">
                    <span class="icon">
                        <i>
                        <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z" stroke="#707070" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 14.0001L11.1 11.1001" stroke="#707070" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </i>
                    </span>
                </button>
            </form>
        </div>
    </div>
    <?php echo do_shortcode('[gtranslate]'); ?>
</div>