<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header id="masthead" class="site-header">
        <div class="container site-header__inner">
            <div class="site-branding">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <div class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <span><?php bloginfo('name'); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => false,
                    )
                );
                ?>
            </nav>



            <button class="burger-menu" id="mobile-menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <div class="mobile-drawer" id="mobile-drawer">
        <div class="mobile-drawer__header">
            <div class="site-branding">
                <div class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="4" width="24" height="24" rx="4" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <span><?php bloginfo('name'); ?></span>
                    </a>
                </div>
            </div>
            <button class="mobile-drawer__close" id="mobile-menu-close" aria-label="Close menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <nav class="mobile-drawer__nav">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container' => false,
                )
            );
            ?>
        </nav>

    </div>
    <div class="mobile-overlay" id="mobile-overlay"></div>