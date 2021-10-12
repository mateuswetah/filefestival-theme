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
        <?php echo $previous; ?>
        <?php echo $next; ?>
    </div>
<?php endif; ?>