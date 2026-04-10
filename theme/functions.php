<?php
/**
 * Landing for Portfolio — Theme Setup
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Constants
define( 'LANDING_VERSION', '1.0.0' );
define( 'LANDING_THEME_DIR', get_template_directory() );
define( 'LANDING_THEME_URI', get_template_directory_uri() );

/**
 * Pro Logic Modules
 */
require_once LANDING_THEME_DIR . '/inc/theme-setup.php';
require_once LANDING_THEME_DIR . '/inc/enqueue.php';
require_once LANDING_THEME_DIR . '/inc/register-blocks.php';
require_once LANDING_THEME_DIR . '/inc/acf-options.php';
