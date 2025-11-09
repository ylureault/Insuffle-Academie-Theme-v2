<?php
$hero_title = get_theme_mod('hero_title', 'Libérez la puissance de l\'intelligence collective');
$hero_subtitle = get_theme_mod('hero_subtitle', 'Organisme de formation');
?>
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></div>
                <h1><?php echo wp_kses_post($hero_title); ?></h1>
                <a href="#formations" class="btn">Découvrir nos formations</a>
            </div>
        </div>
    </div>
</section>