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

/**
 * Helper to check if block is on page (Gutenberg)
 */
function landing_has_block_on_page( $block_name ) {
    if ( ! is_singular() ) return false;
    $post = get_post();
    return has_block( 'acf/' . $block_name, $post->post_content );
}
