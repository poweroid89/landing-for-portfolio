<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Landing_for_Portfolio
 */

get_header(); ?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="container">
            <h1 class="page-title"><?php esc_html_e( '404', 'landing-for-portfolio' ); ?></h1>
            <p><?php esc_html_e( 'Сторінку не знайдено. Можливо, вона була видалена або переміщена.', 'landing-for-portfolio' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( 'На головну', 'landing-for-portfolio' ); ?>
            </a>
        </div>
    </section>
</main>

<?php get_footer();
