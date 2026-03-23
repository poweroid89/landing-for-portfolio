<?php
/**
 * Smart enqueuing of block assets
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function landing_lazy_load_blocks() {
    $blocks = glob( get_template_directory() . '/blocks/*' );

    foreach ( $blocks as $block ) {
        $slug = basename( $block );

        // Якщо блок є на сторінці
        if ( has_block( "acf/$slug" ) ) {
            $css_path = get_template_directory() . "/assets/css/$slug.css";
            $js_path  = get_template_directory() . "/assets/js/$slug.js";

            // Enqueue CSS
            if ( file_exists( $css_path ) ) {
                wp_enqueue_style(
                    "landing-block-$slug",
                    get_template_directory_uri() . "/assets/css/$slug.css",
                    [],
                    filemtime( $css_path )
                );
            }

            // Enqueue JS
            if ( file_exists( $js_path ) ) {
                wp_enqueue_script(
                    "landing-block-$slug",
                    get_template_directory_uri() . "/assets/js/$slug.js",
                    [],
                    filemtime( $js_path ),
                    true
                );
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'landing_lazy_load_blocks' );
