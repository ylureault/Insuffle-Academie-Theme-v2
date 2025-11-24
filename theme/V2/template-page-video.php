<?php
/**
 * Template Name: Page Vidéo
 * Description: Page pour présenter du contenu vidéo ou multimédia
 */

get_header(); ?>

<div id="primary" class="content-area page-video">
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

        <!-- Contenu Vidéo -->
        <section class="page-content-wrapper">
            <div class="container">
                <article class="page-main full-width video-content">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>

        <!-- CTA Formations -->
        <?php insuffle_display_formation_cta(); ?>

    <?php endwhile; ?>
</div>

<style>
.video-content .video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    max-width: 100%;
    background: #000;
    border-radius: 15px;
    margin: 30px 0;
}

.video-content .video-wrapper iframe,
.video-content .video-wrapper video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.video-content .video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.video-content .video-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.video-content .video-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.video-content .video-card-thumbnail {
    position: relative;
    padding-bottom: 56.25%;
    background: #000;
    overflow: hidden;
}

.video-content .video-card-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-content .video-card-thumbnail::after {
    content: "▶";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    opacity: 0.9;
    transition: all 0.3s ease;
}

.video-content .video-card:hover .video-card-thumbnail::after {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1.1);
}

.video-content .video-card-content {
    padding: 20px;
}

.video-content .video-card h3 {
    color: var(--primary);
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.video-content .video-card p {
    color: #666;
    line-height: 1.6;
    font-size: 0.95rem;
}

.video-content .video-duration {
    display: inline-block;
    background: var(--secondary);
    color: #333;
    padding: 4px 10px;
    border-radius: 5px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-top: 10px;
}

@media (max-width: 768px) {
    .video-content .video-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
