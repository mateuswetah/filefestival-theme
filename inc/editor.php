<?php

/* Filters possible color palletes */
function filefestival_theme_setup() {

	add_theme_support( 'editor-color-palette', array(
        array(
            'name' => __( 'Branco', 'filefestival' ),
            'slug' => 'white',
            'color' => '#ffffff',
        ),
        array(
            'name' => __( 'Cinza 1', 'filefestival' ),
            'slug' => 'gray-1',
            'color' => '#cccccc',
        ),
        array(
            'name' => __( 'Cinza 2', 'filefestival' ),
            'slug' => 'gray-2',
            'color' => '#777777',
        ),
        array(
            'name' => __( 'Cinza 3', 'filefestival' ),
            'slug' => 'gray-3',
            'color' => '#676767',
        ),
        array(
            'name' => __( 'Cinza 4', 'filefestival' ),
            'slug' => 'gray-4',
            'color' => '#333333',
        ),
        array(
            'name' => __( 'Cinza 5', 'filefestival' ),
            'slug' => 'gray-5',
            'color' => '#2a2a2a',
        ),
        array(
            'name' => __( 'Preto', 'filefestival' ),
            'slug' => 'black',
            'color' => '#000000',
        )
    ) );
}
add_action( 'after_setup_theme', 'filefestival_theme_setup', 12 );
