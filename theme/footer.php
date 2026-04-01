<footer id="colophon" class="site-footer">
    <div class="container site-footer__inner">
        <!-- Logo / Site Name -->
        <div class="site-footer__branding">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?= esc_url(home_url('/')) ?>" class="site-footer__logo" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Tagline -->
        <?php $tagline = get_field('footer_tagline', 'option'); ?>
        <?php if ($tagline): ?>
            <p class="site-footer__tagline"><?= esc_html($tagline); ?></p>
        <?php endif; ?>

        <!-- Social Icons -->
        <?php $socials = get_field('social_links', 'option'); ?>
        <?php if ($socials): ?>
            <div class="site-footer__socials">
                <?php foreach ($socials as $social): ?>
                    <?php if (!empty($social['url'])): ?>
                        <a href="<?= esc_url($social['url']); ?>" class="site-footer__social-link" target="_blank" rel="noopener noreferrer">
                            <?php if (!empty($social['icon'])): ?>
                                <span class="site-footer__social-icon"><?= $social['icon']; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</footer>

<!-- Fixed Notification Bar -->
<?php
$notification_enabled = get_field('notification_enabled', 'option');
$notification_text    = get_field('notification_text', 'option');
$notification_accent  = get_field('notification_accent', 'option');
$notification_btn_text = get_field('notification_btn_text', 'option');
$notification_btn_url  = get_field('notification_btn_url', 'option');
?>
<?php if ($notification_enabled): ?>
    <div class="notification-bar" id="notification-bar">
        <div class="notification-bar__inner">
            <?php if ($notification_text): ?>
                <span class="notification-bar__text"><?= esc_html($notification_text); ?></span>
            <?php endif; ?>

            <?php if ($notification_accent): ?>
                <span class="notification-bar__accent"><?= esc_html($notification_accent); ?></span>
            <?php endif; ?>

            <?php if ($notification_btn_text): ?>
                <a href="<?= esc_url($notification_btn_url ?: '#'); ?>" class="btn btn-secondary btn-md notification-bar__btn">
                    <?= esc_html($notification_btn_text); ?>
                </a>
            <?php endif; ?>
        </div>

        <button class="notification-bar__close" id="notification-bar-close" aria-label="Закрити">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
