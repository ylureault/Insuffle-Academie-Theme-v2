<?php
/**
 * Template Name: Page Services
 * Description: Page pour présenter les services ou le portfolio
 */

get_header(); ?>

<div id="primary" class="content-area page-services">
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

        <!-- Contenu Services -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width services-content">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<style>
.services-content .services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.services-content .service-card {
    background: white;
    border-radius: 15px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border-top: 4px solid transparent;
}

.services-content .service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-top-color: var(--primary);
}

.services-content .service-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    display: inline-block;
}

.services-content .service-card h3 {
    color: var(--primary);
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.services-content .service-card p {
    color: #666;
    line-height: 1.7;
    margin-bottom: 20px;
}

.services-content .service-features {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    text-align: left;
}

.services-content .service-features li {
    padding: 8px 0;
    color: #555;
}

.services-content .service-features li::before {
    content: "✓";
    color: var(--secondary);
    font-weight: bold;
    margin-right: 10px;
}

@media (max-width: 768px) {
    .services-content .services-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
