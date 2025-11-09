<?php
/**
 * Template Name: Page Équipe
 * Description: Page pour présenter l'équipe ou l'organisme
 */

get_header(); ?>

<div id="primary" class="content-area page-equipe">
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

        <!-- Contenu Équipe -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width equipe-content">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<style>
.equipe-content .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.equipe-content .team-member {
    background: white;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.equipe-content .team-member:hover {
    transform: translateY(-5px);
}

.equipe-content .team-member img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 4px solid var(--secondary);
}

.equipe-content .team-member h3 {
    color: var(--primary);
    margin-bottom: 5px;
}

.equipe-content .team-member .role {
    color: var(--secondary);
    font-weight: 600;
    margin-bottom: 15px;
}

.equipe-content .team-member p {
    color: #666;
    line-height: 1.6;
}
</style>

<?php get_footer(); ?>
