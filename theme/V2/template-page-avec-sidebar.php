<?php
/**
 * Template Name: Page Avec Sidebar
 * Description: Page avec sidebar à droite
 */

get_header(); ?>

<div id="primary" class="content-area page-with-sidebar">
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

        <!-- Contenu avec Sidebar -->
        <section class="page-content-wrapper">
            <div class="page-container">

                <article class="page-main">
                    <?php the_content(); ?>
                </article>

                <aside class="page-sidebar">
                    <?php if (is_active_sidebar('page-sidebar')) : ?>
                        <?php dynamic_sidebar('page-sidebar'); ?>
                    <?php else : ?>
                        <div class="sidebar-widget">
                            <h3>Contact</h3>
                            <p>📞 <a href="tel:+33980808962">09 80 80 89 62</a></p>
                            <p>✉️ <a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a></p>
                        </div>
                    <?php endif; ?>
                </aside>

            </div>
        </section>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
