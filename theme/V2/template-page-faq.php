<?php
/**
 * Template Name: Page FAQ
 * Description: Page pour afficher des questions/réponses (FAQ)
 */

get_header(); ?>

<div id="primary" class="content-area page-faq">
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

        <!-- Contenu FAQ -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width faq-content">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<style>
.faq-content h2,
.faq-content h3 {
    color: var(--primary);
    margin-top: 40px;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--secondary);
}

.faq-content details {
    background: white;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.faq-content details:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.faq-content summary {
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--primary);
    cursor: pointer;
    list-style: none;
    display: flex;
    align-items: center;
    gap: 10px;
}

.faq-content summary::-webkit-details-marker {
    display: none;
}

.faq-content summary::before {
    content: "▶";
    color: var(--secondary);
    font-size: 0.8em;
    transition: transform 0.3s ease;
}

.faq-content details[open] summary::before {
    transform: rotate(90deg);
}

.faq-content details p {
    margin-top: 15px;
    line-height: 1.6;
}
</style>

<?php get_footer(); ?>
