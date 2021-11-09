<?php 

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
        <a class="tainacan-single-navigation-links--list" href="<?php echo tainacan_get_source_item_list_url(); ?>">
            <svg version="1.1" viewBox="0 0 42.621 21.621" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><g transform="matrix(1.3333 0 0 -1.3333 0 21.621)"><path class="cls-1" transform="matrix(.75 0 0 -.75 0 16.216)" d="m0-0.0019531v1.5 13.5h36.883l-3.4434 3.4414-1.0625 1.0586 2.123 2.123 8.123-8.123-7.0625-7.0586-1.0605-1.0605-2.123 2.1191 4.5 4.5h-33.877v-10.5-1.5h-3z" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1.3333" /></g></svg><span><?php echo __('Voltar para a lista', 'filefesival') ?></span>
        </a>
        <?php echo $previous; ?>
        <?php echo $next; ?>
    </div>
<?php endif; ?>