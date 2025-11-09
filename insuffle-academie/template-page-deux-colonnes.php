<?php
/**
 * Template Name: Page Deux Colonnes
 * Description: Page avec mise en page deux colonnes (50/50)
 */

get_header(); ?>

<div id="primary" class="content-area page-deux-colonnes">
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

        <!-- Contenu Deux Colonnes -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width deux-colonnes-content">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<style>
.deux-colonnes-content .two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin: 30px 0;
    align-items: start;
}

.deux-colonnes-content .column {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.deux-colonnes-content .column h2,
.deux-colonnes-content .column h3 {
    color: var(--primary);
    margin-bottom: 20px;
}

.deux-colonnes-content .column img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 20px 0;
}

.deux-colonnes-content .column ul,
.deux-colonnes-content .column ol {
    margin: 20px 0;
    padding-left: 25px;
}

.deux-colonnes-content .column li {
    margin-bottom: 10px;
    line-height: 1.6;
}

@media (max-width: 992px) {
    .deux-colonnes-content .two-columns {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}
</style>

<?php get_footer(); ?>
