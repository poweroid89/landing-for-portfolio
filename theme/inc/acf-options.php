<?php
/**
 * ACF Options Page — Theme Settings
 *
 * Реєструє сторінку налаштувань теми в адмін-панелі:
 * - Соціальні мережі (іконка + URL, repeater)
 * - Fixed notification bar (текст, текст акценту, кнопка, вкл/викл)
 */

if (!defined('ABSPATH')) exit;

/**
 * 💡 Чому acf/init, а не напряму:
 * acf_add_options_page() доступна лише ПІСЛЯ ініціалізації ACF.
 * Якщо визвати її в functions.php до acf/init — функція ще не існує.
 */
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Налаштування теми',
            'menu_title' => 'Theme Settings',
            'menu_slug'  => 'theme-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-admin-customizer',
            'position'   => 2,
        ]);
    }
});
