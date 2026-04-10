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

    // ── FONTS ─────────────────────────────────────
    // Option A: Google Fonts (uncomment and set your font)
    // wp_enqueue_style(
    //     'landing-fonts',
    //     'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
    //     [],
    //     null
    // );

    // Option B: Self-hosted fonts — @font-face defined in src/scss/base/_fonts.scss

    // ── STYLES ────────────────────────────────────
    wp_enqueue_style(
        'landing-styles',
        LANDING_THEME_URI . '/assets/css/main.css',
        [],
        $version
    );

    // ── SCRIPTS ───────────────────────────────────
    // true = load in footer (non-render-blocking)
    wp_enqueue_script(
        'landing-scripts',
        LANDING_THEME_URI . '/assets/js/main.js',
        [],
        $version,
        true
    );

    // PHP → JS data (AJAX URL, nonce)
    wp_localize_script('landing-scripts', 'landingData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('landing_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'landing_scripts');

/**
 * Load theme styles in the block editor
 */
function landing_admin_assets()
{
    wp_enqueue_style('landing-admin-styles', LANDING_THEME_URI . '/assets/css/main.css', [], LANDING_VERSION);
}
add_action('enqueue_block_editor_assets', 'landing_admin_assets');

/**
 * Add "defer" to JS scripts (non-render-blocking)
 */
function landing_defer_scripts($tag, $handle, $src)
{
    $defer_handles = ['landing-scripts'];

    if (in_array($handle, $defer_handles) || strpos($src, '/blocks/') !== false) {
        if (strpos($tag, ' defer') === false) {
            $tag = str_replace(' src', ' defer="defer" src', $tag);
        }
    }

    return $tag;
}
add_filter('script_loader_tag', 'landing_defer_scripts', 10, 3);
