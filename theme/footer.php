<footer id="colophon" class="site-footer">
    <div class="container site-footer__inner">

        <div class="site-footer__branding">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?= esc_url(home_url('/')) ?>" class="site-footer__logo" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <p class="site-footer__copy">
            &copy; <?= date('Y') ?> <?php bloginfo('name'); ?>. All rights reserved.
        </p>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
