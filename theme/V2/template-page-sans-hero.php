<?php
/**
 * Template Name: Page Sans Hero
 * Description: Page sans section hero (commence directement par le contenu)
 */

get_header(); ?>

<div id="primary" class="content-area page-no-hero">
    <?php while (have_posts()) : the_post(); ?>

        <!-- Contenu direct -->
        <section class="page-content-wrapper" style="padding-top: 40px;">
            <div class="container">
                <article class="page-main">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
