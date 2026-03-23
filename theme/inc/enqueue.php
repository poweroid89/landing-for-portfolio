<?php
/**
 * Enqueue scripts and styles
 */

if (!defined('ABSPATH')) {
    exit;
}

function landing_scripts()
{
    $version = LANDING_VERSION;

    // Google Fonts
    wp_enqueue_style('landing-fonts', 'https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400;500&Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap', [], null);

    // Підключаємо стилі (скомпільовані Gulp)
    wp_enqueue_style('landing-styles', LANDING_THEME_URI . '/assets/css/main.css', [], $version);

    // Підключаємо скрипти
    wp_enqueue_script('landing-scripts', LANDING_THEME_URI . '/assets/js/main.js', [], $version, true);

    // Передаємо дані з PHP в JS (опціонально)
    wp_localize_script('landing-scripts', 'landingData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('landing_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'landing_scripts');

/**
 * Підключення стилів для адмін-панелі (опціонально)
 */
function landing_admin_assets()
{
    wp_enqueue_style('landing-admin-styles', LANDING_THEME_URI . '/assets/css/main.css', [], LANDING_VERSION);
}
add_action('enqueue_block_editor_assets', 'landing_admin_assets');
