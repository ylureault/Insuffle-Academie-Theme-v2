<?php
/**
 * Template Name: Page Témoignages
 * Description: Page pour afficher des témoignages et avis clients
 */

get_header(); ?>

<div id="primary" class="content-area page-temoignages">
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

        <!-- Contenu Témoignages -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width temoignages-content">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<style>
.temoignages-content .testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.temoignages-content .testimonial-card {
    background: white;
    border-radius: 15px;
    padding: 35px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    position: relative;
    transition: transform 0.3s ease;
}

.temoignages-content .testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.temoignages-content .testimonial-card::before {
    content: """;
    position: absolute;
    top: 20px;
    left: 25px;
    font-size: 80px;
    color: var(--secondary);
    opacity: 0.3;
    line-height: 1;
}

.temoignages-content .testimonial-text {
    font-style: italic;
    line-height: 1.7;
    color: #444;
    margin-bottom: 25px;
    position: relative;
    z-index: 1;
}

.temoignages-content .testimonial-author {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.temoignages-content .testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--secondary);
}

.temoignages-content .testimonial-info h4 {
    color: var(--primary);
    margin: 0 0 5px 0;
    font-size: 1.1rem;
}

.temoignages-content .testimonial-role {
    color: #666;
    font-size: 0.9rem;
}

.temoignages-content .testimonial-rating {
    color: var(--secondary);
    font-size: 1.2rem;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .temoignages-content .testimonials-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
