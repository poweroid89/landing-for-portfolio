<?php
/**
 * Landing theme setup
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function landing_setup() {
    // Підтримка тегів title
    add_theme_support( 'title-tag' );

    // Підтримка мініатюр посту
    add_theme_support( 'post-thumbnails' );

    // Підтримка логотипу
    add_theme_support( 'custom-logo' );

    // Підтримка HTML5 для форм та галерей
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Реєстрація меню
    register_nav_menus( [
        'primary' => esc_html__( 'Primary Menu', 'landing-for-portfolio' ),
        'footer'  => esc_html__( 'Footer Menu', 'landing-for-portfolio' ),
    ] );

    // Підтримка Gutenberg стилів
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/main.css' );
}
add_action( 'after_setup_theme', 'landing_setup' );

/**
 * 📥 ACF JSON Synchronization
 * Save field groups to theme/acf-json for version control and easy syncing
 */
add_filter('acf/settings/save_json', function($path) {
    return LANDING_THEME_DIR . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]); // Remove default path
    $paths[] = LANDING_THEME_DIR . '/acf-json';
    return $paths;
});
