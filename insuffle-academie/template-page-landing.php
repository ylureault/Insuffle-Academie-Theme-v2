<?php
/**
 * Template Name: Page Landing
 * Description: Page d'atterrissage sans header/footer (pour campagnes marketing)
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('landing-page'); ?>>

<?php while (have_posts()) : the_post(); ?>

    <div class="landing-container">
        <?php the_content(); ?>
    </div>

<?php endwhile; ?>

<?php wp_footer(); ?>
</body>
</html>
