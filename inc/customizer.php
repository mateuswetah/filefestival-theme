<?php

/**
 * FileFestival Theme Customizer
 *
 * @package filefestival
 */

/**
 * Add postMessage support for site title for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function filefestival_customize_register($wp_customize) {


    /* Destaques das coleções */
    $wp_customize->add_section('filefestival_tainacan_collections_list', array(
        'title' => __('Lista de Coleções do Tainacan', 'filefestival'),
    ));

    // Loads list of Tainacan collections
    $repository = \Tainacan\Repositories\Collections::get_instance();
    $collections_options = [
        '' => __('Nenhuma coleção', 'filefestival')
    ];
    $collections = $repository->fetch()->posts;

    foreach($collections as $collection) {
        $collections_options[$collection->ID] = $collection->post_title;
    }

    // Adds option to select the main three collections on the collection list
    $wp_customize->add_setting('filefestival_tainacan_collection_first', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_collection_first', array(
        'label' => __('Coleção de destaque 1', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_collections_list',
        'settings' => 'filefestival_tainacan_collection_first',
        'priority' => 2,
        'choices' => $collections_options
    ));
    $wp_customize->add_setting('filefestival_tainacan_collection_second', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_collection_second', array(
        'label' => __('Coleção de destaque 2', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_collections_list',
        'settings' => 'filefestival_tainacan_collection_second',
        'priority' => 2,
        'choices' => $collections_options
    ));
    $wp_customize->add_setting('filefestival_tainacan_collection_third', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_collection_third', array(
        'label' => __('Coleção de destaque 3', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_collections_list',
        'settings' => 'filefestival_tainacan_collection_third',
        'priority' => 2,
        'choices' => $collections_options
    ));


    // Adds option to select the subscription form
    $wp_customize->add_setting('filefestival_tainacan_collection_subscription', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_collection_subscription', array(
        'label' => __('Coleção da Ficha de Inscrição', 'filefestival'),
        'description' => __('Esta coleção não aparecerá na lista de coleções', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_collections_list',
        'settings' => 'filefestival_tainacan_collection_subscription',
        'priority' => 2,
        'choices' => $collections_options
    ));

    // Tainacan collections list description
    $wp_customize->add_setting('filefestival_tainacan_collections_archive_description', array(
        'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        'type' => 'theme_mod',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_collections_archive_description', array(
        'label'     => __('Descrição abaixo do título da página', 'iphan-inrc'),
        'type'      => 'textarea',
        'section'   => 'filefestival_tainacan_collections_list',
        'settings'  => 'filefestival_tainacan_collections_archive_description',
        'priority'  => 1,
    ));
    $wp_customize->selective_refresh->add_partial('filefestival_tainacan_collections_archive_description', array(
        'selector'          => '.archive-description',
        'render_callback'   => '__return_false',
        'fallback_refresh'  => true
    ));

    /* Filefestival single item templates */
    $wp_customize->add_section('filefestival_tainacan_single_items_templates', array(
        'title' => __('Página do Item do Tainacan', 'filefestival'),
    ));

    // Adds option to select which collection will have the Works template
    $wp_customize->add_setting('filefestival_tainacan_single_item_template_works', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_single_item_template_works', array(
        'label' => __('Coleção com o template das Obras', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_single_items_templates',
        'settings' => 'filefestival_tainacan_single_item_template_works',
        'priority' => 2,
        'choices' => $collections_options
    ));

    // Adds option to select which collection will have the Participants template
    $wp_customize->add_setting('filefestival_tainacan_single_item_template_participants', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_single_item_template_participants', array(
        'label' => __('Coleção com o template dos Participantes', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_single_items_templates',
        'settings' => 'filefestival_tainacan_single_item_template_participants',
        'priority' => 2,
        'choices' => $collections_options
    ));

    // Adds option to select which collection will have the Eventos template
    $wp_customize->add_setting('filefestival_tainacan_single_item_template_events', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_single_item_template_events', array(
        'label' => __('Coleção com o template dos Eventos', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_single_items_templates',
        'settings' => 'filefestival_tainacan_single_item_template_events',
        'priority' => 2,
        'choices' => $collections_options
    ));

    // Adds option to select which collection will have the Activities template
    $wp_customize->add_setting('filefestival_tainacan_single_item_template_activities', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_single_item_template_activities', array(
        'label' => __('Coleção com o template das Atividades Educacionais', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_single_items_templates',
        'settings' => 'filefestival_tainacan_single_item_template_activities',
        'priority' => 2,
        'choices' => $collections_options
    ));

    // Adds option to select which collection will have the Publications template
    $wp_customize->add_setting('filefestival_tainacan_single_item_template_publications', array(
        'default' => '',
        'type' => 'theme_mod',
        'transport'  => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('filefestival_tainacan_single_item_template_publications', array(
        'label' => __('Coleção com o template das Publicações & Mídia', 'filefestival'),
        'type' => 'select',
        'section' => 'filefestival_tainacan_single_items_templates',
        'settings' => 'filefestival_tainacan_single_item_template_publications',
        'priority' => 2,
        'choices' => $collections_options
    ));
    
}

add_action('customize_register', 'filefestival_customize_register');