<?php
/**
 * The template for displaying all single posts and pages
 *
 * @package Landing_for_Portfolio
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer();
