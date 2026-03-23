<?php
/**
 * Auto-registering blocks from the blocks/ folder
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Реєстрація кастомної категорії для блоків
 */
function landing_block_categories( $categories ) {
    return array_merge(
        [
            [
                'slug'  => 'landing-for-portfolio',
                'title' => 'Landing',
                'icon'  => 'admin-site', // Іконка для категорії
            ],
        ],
        $categories
    );
}
add_filter( 'block_categories_all', 'landing_block_categories', 10, 2 );

function landing_register_blocks() {
    // Скануємо всі папки в blocks/
    $blocks = glob( get_template_directory() . '/blocks/*' );

    foreach ( $blocks as $block ) {
        if ( file_exists( $block . '/block.json' ) ) {
            // Реєструємо блок автоматично
            register_block_type( $block );
        }
    }
}
add_action( 'init', 'landing_register_blocks' );
