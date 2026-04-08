<?php
/**
 * Enqueue scripts and styles
 *
 * 💡 Чому шрифти підключаються окремо від CSS:
 * Google Fonts / local fonts мають свій life-cycle.
 * Ми хочемо preconnect до Google CDN якомога раніше,
 * а кастомні шрифти підвантажувати локально (менше latency).
 */

if (!defined('ABSPATH')) {
    exit;
}

function landing_scripts()
{
    $version = LANDING_VERSION;

    // ── ШРИФТИ ──────────────────────────────────────

    // 1. MTS Wide — self-hosted (кастомний шрифт, немає на Google Fonts)
    //    Файли лежать у theme/assets/fonts/
    //    @font-face підключається через _fonts.scss
    //
    // 💡 Чому self-host:
    // Зовнішній запит (Google Fonts) = DNS lookup + TCP handshake.
    // Self-hosted шрифти завантажуються з нашого сервера = 0 latency.
    // Для кастомного шрифту MTS Wide — це єдиний варіант.

    // 2. Montserrat — Google Fonts
    //    Ваги: 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold)
    wp_enqueue_style(
        'landing-fonts-montserrat',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap',
        [],
        null // null = без версії → кешується browser'ом ефективніше
    );

    // 3. Swiper CSS (CDN)
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        null
    );

    // Головний CSS тепер інлайниться прямо в HTML (0 мережевих запитів для FCP)
    // wp_enqueue_style('landing-styles', LANDING_THEME_URI . '/assets/css/main.css', ['landing-fonts-montserrat'], $version);
    
    // ── СКРИПТИ ──────────────────────────────────────

    // Swiper JS (CDN)
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);

    // Головний JS (мобільне меню, scroll reveal, анімації)
    // true = підключається в footer (не блокує рендеринг)
    //
    // 💡 Чому в footer:
    // JS у <head> блокує parsing HTML → сторінка "завмирає".
    // JS у footer → HTML рендериться спочатку → потім JS.
    // Це критично для LCP (Largest Contentful Paint).
    wp_enqueue_script('landing-scripts', LANDING_THEME_URI . '/assets/js/main.js', [], $version, true);

    // PHP → JS дані (AJAX URL, nonce для безпечних запитів)
    wp_localize_script('landing-scripts', 'landingData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('landing_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'landing_scripts');

/**
 * Preconnect до Google Fonts CDN
 *
 * 💡 Чому preconnect:
 * Браузер починає DNS/TCP/TLS handshake ЩЕ ДО того,
 * як побачить посилання на шрифт. Економить ~100-200ms.
 * Це один рядок HTML, але значний вплив на швидкість.
 */
function landing_preconnect_fonts()
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'landing_preconnect_fonts', 1);

/**
 * Підключення стилів для адмін-панелі (Gutenberg editor)
 */
function landing_admin_assets()
{
    wp_enqueue_style('landing-admin-styles', LANDING_THEME_URI . '/assets/css/main.css', [], LANDING_VERSION);
}
add_action('enqueue_block_editor_assets', 'landing_admin_assets');

/**
 * Асинхронне завантаження CSS (Google Fonts, Swiper) для PageSpeed
 * Використовує трюк media="print" onload="this.media='all'"
 */
function landing_async_styles($html, $handle, $href, $media)
{
    // Стилі, які можна відкласти без шкоди (шрифти, слайдери)
    $async_handles = ['landing-fonts-montserrat', 'swiper-css'];

    if (in_array($handle, $async_handles)) {
        $async_html = '<link rel="preload" as="style" href="' . esc_url($href) . '" />' . "\n";
        $async_html .= '<link rel="stylesheet" id="' . esc_attr($handle) . '-css" href="' . esc_url($href) . '" media="print" onload="this.media=\'all\'" />' . "\n";
        $async_html .= '<noscript><link rel="stylesheet" href="' . esc_url($href) . '" media="all" /></noscript>' . "\n";
        return $async_html;
    }

    // Головний main.css тепер інлайниться, тому тут ми його ігноруємо
    return $html;
}
add_filter('style_loader_tag', 'landing_async_styles', 10, 4);

/**
 * Інлайнимо main.css для досягнення блискавичного FCP
 * Замість мережевого запиту код стилів вже буде в HTML
 */
function landing_inline_main_css() {
    $css_path = LANDING_THEME_DIR . '/assets/css/main.css';
    if (file_exists($css_path)) {
        $css_content = file_get_contents($css_path);
        
        // Оскільки CSS тепер в <head>, відносні шляхи (../fonts/) зламалися.
        // Замінюємо їх на абсолютні шляхи до активної теми.
        $css_content = str_replace('../', LANDING_THEME_URI . '/assets/', $css_content);

        echo '<style id="landing-main-inline-css">';
        echo $css_content;
        echo '</style>' . "\n";
    }
}
add_action('wp_head', 'landing_inline_main_css', 5);

/**
 * Add "defer" attribute to JS scripts to eliminate render-blocking and shorten the critical request chain
 */
function landing_defer_scripts($tag, $handle, $src)
{
    // Відкладаємо Swiper, Main JS та всі скрипти блоків (які містять theme/blocks у шляху)
    $defer_handles = ['swiper-js', 'landing-scripts'];
    
    if (in_array($handle, $defer_handles) || strpos($src, '/blocks/') !== false) {
        if (strpos($tag, ' defer') === false) {
            $tag = str_replace(' src', ' defer="defer" src', $tag);
        }
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'landing_defer_scripts', 10, 3);

/**
 * Preload custom local fonts to prioritize their downloading
 */
function landing_preload_local_fonts()
{
    $font_medium = LANDING_THEME_URI . '/assets/fonts/mts-wide/MTSWide-Medium.woff2';
    $font_bold = LANDING_THEME_URI . '/assets/fonts/mts-wide/MTSWide-Bold.woff2';
    
    echo '<link rel="preload" href="' . esc_url($font_medium) . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
    echo '<link rel="preload" href="' . esc_url($font_bold) . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
}
add_action('wp_head', 'landing_preload_local_fonts', 1);

/**
 * Preload the hero image for better LCP (Largest Contentful Paint)
 */
function landing_preload_hero_image() {
    // Only on front page or pages with hero block
    if ( ! is_front_page() && ! (function_exists('landing_has_block_on_page') && landing_has_block_on_page('hero')) ) {
        return;
    }

    $post = get_post();
    if ( ! $post ) return;

    $blocks = parse_blocks( $post->post_content );
    $hero_data = null;

    foreach ( $blocks as $block ) {
        if ( isset($block['blockName']) && $block['blockName'] === 'acf/hero' ) {
            $hero_data = isset($block['attrs']['data']) ? $block['attrs']['data'] : null;
            break;
        }
    }

    // Default paths from render.php if no image set in block
    $default_desktop = LANDING_THEME_URI . '/assets/images/photos/pill_1x.webp';
    $default_mobile  = LANDING_THEME_URI . '/assets/images/photos/pill_mob_1x.webp';

    if ( $hero_data ) {
        $d1x = isset($hero_data['hero_image_desktop_1x']) ? landing_get_image_url($hero_data['hero_image_desktop_1x']) : '';
        $d2x = isset($hero_data['hero_image_desktop_2x']) ? landing_get_image_url($hero_data['hero_image_desktop_2x']) : '';
        $m1x = isset($hero_data['hero_image_mobile_1x']) ? landing_get_image_url($hero_data['hero_image_mobile_1x']) : '';
        $m2x = isset($hero_data['hero_image_mobile_2x']) ? landing_get_image_url($hero_data['hero_image_mobile_2x']) : '';

        if ( $d1x ) {
            $desktop_srcset = $d1x . ($d2x ? ", {$d2x} 2x" : "");
            // For mobile, use mobile fields, or fallback to desktop if empty
            $actual_m1x = $m1x ?: ($m2x ?: $d1x);
            $mobile_srcset = $actual_m1x . ($m2x ? ", {$m2x} 2x" : "");

            echo '<link rel="preload" as="image" href="' . esc_url($actual_m1x) . '" imagesrcset="' . esc_attr($mobile_srcset) . '" media="(max-width: 768px)">' . "\n";
            echo '<link rel="preload" as="image" href="' . esc_url($d1x) . '" imagesrcset="' . esc_attr($desktop_srcset) . '" media="(min-width: 769px)">' . "\n";
            return;
        }
    }

    // Fallback if no specific data found but block exists
    echo '<link rel="preload" as="image" href="' . esc_url($default_mobile) . '" media="(max-width: 768px)">' . "\n";
    echo '<link rel="preload" as="image" href="' . esc_url($default_desktop) . '" media="(min-width: 769px)">' . "\n";
}
add_action('wp_head', 'landing_preload_hero_image', 1);
