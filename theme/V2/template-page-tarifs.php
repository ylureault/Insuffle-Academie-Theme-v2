<?php
/**
 * Template Name: Page Tarifs
 * Description: Page pour afficher des tarifs/pricing
 */

get_header(); ?>

<div id="primary" class="content-area page-tarifs">
    <?php while (have_posts()) : the_post(); ?>

        <!-- Hero Section -->
        <section class="page-hero">
            <div class="page-hero-content">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <div class="page-intro"><?php the_excerpt(); ?></div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Contenu -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
