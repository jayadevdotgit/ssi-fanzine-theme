<?php

/**
 * SSI FANZINE Theme Setup
 */

function ssi_fanzine_setup() {

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ssi-fanzine'),
    ));
}

add_action('after_setup_theme', 'ssi_fanzine_setup');


/**
 * Load theme stylesheet
 */

function ssi_fanzine_assets() {

    wp_enqueue_style(
        'ssi-fanzine-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}

add_action('wp_enqueue_scripts', 'ssi_fanzine_assets');
