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

    // ── СТИЛІ ───────────────────────────────────────

    // Головний CSS (скомпільований Gulp з SCSS)
    wp_enqueue_style('landing-styles', LANDING_THEME_URI . '/assets/css/main.css', ['landing-fonts-montserrat'], $version);

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
