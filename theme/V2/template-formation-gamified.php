<?php
/**
 * Template Name: Formation Gamifiée
 * Description: Template pour les pages de formations gamifiées avec un design immersif
 * Version: 1.0
 */

get_header(); ?>

<div id="primary" class="content-area formation-gamified">
    <?php
    while (have_posts()) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('formation-article'); ?>>

            <div class="entry-content">
                <?php
                // Afficher le contenu de la page (blocs Gutenberg)
                the_content();
                ?>
            </div><!-- .entry-content -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>
</div><!-- #primary -->

<?php
// Afficher le CTA Formations (paramétrable dans Apparence > Personnaliser > CTA Formations)
insuffle_display_formation_cta();

get_footer();
