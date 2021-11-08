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
        <a href="<?php echo tainacan_get_source_item_list_url(); ?>">
        <svg id="Camada_1" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31.97 16.22"><g id="return-down-forward-sharp"><path id="Caminho_38" data-name="Caminho 38" class="cls-1" d="M25.88,14.62l4.5-4.5-4.5-4.5"/><path id="Caminho_39" data-name="Caminho 39" class="cls-1" d="M29.25,10.12H1.12v-9"/></g></svg><span><?php echo __('Voltar para a lsita', 'filefesival') ?></span>
        </a>
        <?php echo $previous; ?>
        <?php echo $next; ?>
    </div>
<?php endif; ?>