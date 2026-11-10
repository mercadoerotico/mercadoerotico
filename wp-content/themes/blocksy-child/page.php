<?php
/**
 * The template for displaying all pages
 * Blocksy Child - Portal Mercado Erótico
 */

get_header();

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="site-main me-page-main">
        <div class="me-page-entry-content">
            <?php the_content(); ?>
        </div>
    </main>
    <?php
endwhile;

get_footer();
