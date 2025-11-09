<?php
/**
 * Template Name: Page Pleine Largeur
 * Description: Page sans sidebar, contenu sur toute la largeur
 */

get_header(); ?>

<div id="primary" class="content-area page-full-width">
    <?php while (have_posts()) : the_post(); ?>

        <!-- Hero Section -->
        <section class="page-hero">
            <div class="page-hero-content">
                <nav class="breadcrumb">
                    <a href="<?php echo home_url(); ?>">Accueil</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current"><?php the_title(); ?></span>
                </nav>

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

        <?php
        // CTA automatique pour formations
        $is_formation = stripos(get_post_field('post_name', wp_get_post_parent_id(get_the_ID())), 'formation') !== false;
        if ($is_formation) {
            insuffle_display_formation_cta();
        }
        ?>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
