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
            'slug' => 'gray1',
            'color' => '#cccccc',
        ),
        array(
            'name' => __( 'Cinza 2', 'filefestival' ),
            'slug' => 'gray2',
            'color' => '#777777',
        ),
        array(
            'name' => __( 'Cinza 3', 'filefestival' ),
            'slug' => 'gray3',
            'color' => '#676767',
        ),
        array(
            'name' => __( 'Cinza 4', 'filefestival' ),
            'slug' => 'gray4',
            'color' => '#333333',
        ),
        array(
            'name' => __( 'Cinza 5', 'filefestival' ),
            'slug' => 'gray5',
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
