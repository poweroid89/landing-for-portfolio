<?php
/**
 * Landing for Portfolio Advanced Theme Setup
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Constants
define( 'LANDING_VERSION', '1.0.1' );
define( 'LANDING_THEME_DIR', get_template_directory() );
define( 'LANDING_THEME_URI', get_template_directory_uri() );

/**
 * Pro Logic Modules
 */
require_once LANDING_THEME_DIR . '/inc/theme-setup.php';
require_once LANDING_THEME_DIR . '/inc/enqueue.php';
require_once LANDING_THEME_DIR . '/inc/register-blocks.php';
require_once LANDING_THEME_DIR . '/inc/enqueue-assets.php'; // Lazy loading logic
require_once LANDING_THEME_DIR . '/inc/acf-options.php';     // ACF Options page

/**
 * Helper to check if block is on page (Gutenberg)
 */
function landing_has_block_on_page( $block_name ) {
    if ( ! is_singular() ) return false;
    $post = get_post();
    return has_block( 'acf/' . $block_name, $post->post_content );
}

/**
 * Universal helper to get image URL from ACF field value
 * (Handles: ID, Array, Relative Path, or full URL)
 */
function landing_get_image_url($val) {
    if (!$val) return '';
    
    // 1: Image Array
    if (is_array($val)) return isset($val['url']) ? $val['url'] : '';
    
    // 2: ID
    if (is_numeric($val)) return wp_get_attachment_image_url($val, 'full');
    
    // 3: Relative path (e.g. "assets/images/X.webp")
    if (is_string($val) && !preg_match('/^https?:\/\//i', $val) && !str_starts_with($val, '/wp-content/')) {
        return LANDING_THEME_URI . '/' . ltrim($val, '/');
    }
    
    // 4: Absolute URL
    return $val;
}
