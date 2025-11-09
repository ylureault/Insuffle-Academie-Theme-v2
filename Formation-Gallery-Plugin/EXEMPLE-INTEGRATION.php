<?php
/**
 * EXEMPLES D'INTÉGRATION DU PLUGIN FORMATION GALLERY
 *
 * Ce fichier contient des exemples de code pour intégrer
 * les galeries de formation dans vos templates WordPress
 */

// ===========================================
// EXEMPLE 1 : Affichage simple dans single-formation.php
// ===========================================

?>
<!-- Dans votre template single-formation.php -->
<div class="formation-content">
    <h1><?php the_title(); ?></h1>

    <div class="formation-description">
        <?php the_content(); ?>
    </div>

    <!-- Afficher la galerie si elle existe -->
    <?php if (fg_has_gallery()) : ?>
        <section class="formation-gallery-section">
            <h2>Galerie photos</h2>
            <?php fg_the_gallery(); ?>
        </section>
    <?php endif; ?>
</div>

<?php
// ===========================================
// EXEMPLE 2 : Affichage avec options personnalisées
// ===========================================
?>

<?php if (fg_has_gallery()) : ?>
    <section class="formation-gallery-section">
        <div class="section-header">
            <h2>Galerie photos de la formation</h2>
            <p class="gallery-count">
                <?php echo fg_get_gallery_count(); ?> photos disponibles
            </p>
        </div>

        <?php
        // Affichage avec 4 colonnes et grandes images
        fg_the_gallery(get_the_ID(), array(
            'columns' => 4,
            'size' => 'large',
            'style' => 'grid',
            'show_captions' => 'yes'
        ));
        ?>
    </section>
<?php endif; ?>

<?php
// ===========================================
// EXEMPLE 3 : Utilisation du shortcode dans le contenu
// ===========================================
?>

<!-- Dans l'éditeur WordPress (Gutenberg ou Classique) -->
[formation_gallery]

<!-- Avec options -->
[formation_gallery columns="4" size="large" show_captions="no"]

<?php
// ===========================================
// EXEMPLE 4 : Affichage dans une boucle (archive-formations.php)
// ===========================================
?>

<?php if (have_posts()) : ?>
    <div class="formations-grid">
        <?php while (have_posts()) : the_post(); ?>
            <article class="formation-card">
                <h3><?php the_title(); ?></h3>

                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium'); ?>
                <?php endif; ?>

                <div class="formation-excerpt">
                    <?php the_excerpt(); ?>
                </div>

                <!-- Badge si la formation a une galerie -->
                <?php if (fg_has_gallery()) : ?>
                    <div class="formation-gallery-badge">
                        <span class="dashicons dashicons-camera"></span>
                        <?php echo fg_get_gallery_count(); ?> photos
                    </div>
                <?php endif; ?>

                <a href="<?php the_permalink(); ?>" class="button">
                    Voir la formation
                </a>
            </article>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php
// ===========================================
// EXEMPLE 5 : Widget ou sidebar
// ===========================================
?>

<!-- Dans un widget de sidebar -->
<?php if (is_singular('formation') && fg_has_gallery()) : ?>
    <div class="widget formation-gallery-widget">
        <h3 class="widget-title">Galerie de photos</h3>
        <?php
        fg_the_gallery(get_the_ID(), array(
            'columns' => 2,
            'size' => 'thumbnail',
            'style' => 'grid',
            'show_captions' => 'no'
        ));
        ?>
    </div>
<?php endif; ?>

<?php
// ===========================================
// EXEMPLE 6 : Onglets avec différentes sections
// ===========================================
?>

<div class="formation-tabs">
    <ul class="tabs-nav">
        <li><a href="#tab-description">Description</a></li>
        <li><a href="#tab-programme">Programme</a></li>
        <?php if (fg_has_gallery()) : ?>
            <li>
                <a href="#tab-gallery">
                    Galerie (<?php echo fg_get_gallery_count(); ?>)
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <div class="tabs-content">
        <div id="tab-description" class="tab-pane">
            <?php the_content(); ?>
        </div>

        <div id="tab-programme" class="tab-pane">
            <!-- Programme de la formation -->
        </div>

        <?php if (fg_has_gallery()) : ?>
            <div id="tab-gallery" class="tab-pane">
                <?php fg_the_gallery(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// ===========================================
// EXEMPLE 7 : Intégration avec Elementor ou Page Builder
// ===========================================
?>

<!-- Dans un shortcode Elementor -->
<!-- Ajouter un widget "Shortcode" et insérer : -->
[formation_gallery id="<?php echo get_the_ID(); ?>" columns="3"]

<?php
// ===========================================
// EXEMPLE 8 : Lightbox sur l'image mise en avant
// ===========================================
?>

<div class="formation-header">
    <?php if (has_post_thumbnail()) : ?>
        <div class="formation-thumbnail-wrapper">
            <?php the_post_thumbnail('large'); ?>

            <?php if (fg_has_gallery()) : ?>
                <a href="#formation-gallery" class="view-gallery-btn">
                    <span class="dashicons dashicons-images-alt2"></span>
                    Voir toutes les photos (<?php echo fg_get_gallery_count(); ?>)
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <h1><?php the_title(); ?></h1>
</div>

<!-- Plus bas dans la page -->
<div id="formation-gallery">
    <?php fg_the_gallery(); ?>
</div>

<?php
// ===========================================
// EXEMPLE 9 : Ajouter un style personnalisé
// ===========================================
?>

<style>
/* Personnalisation de la galerie */
.formation-gallery-section {
    margin: 40px 0;
    padding: 40px 20px;
    background: #f9f9f9;
    border-radius: 10px;
}

.formation-gallery-section h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2em;
    color: #333;
}

.gallery-count {
    text-align: center;
    color: #666;
    font-style: italic;
    margin-bottom: 20px;
}

.formation-gallery-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    background: #0073aa;
    color: white;
    border-radius: 5px;
    font-size: 12px;
    margin-top: 10px;
}
</style>

<?php
// ===========================================
// EXEMPLE 10 : Fonction personnalisée dans functions.php
// ===========================================
?>

<?php
/**
 * Ajouter automatiquement la galerie après le contenu des formations
 */
function custom_add_gallery_after_content($content) {
    if (is_singular('formation') && fg_has_gallery()) {
        $gallery_html = '<div class="auto-gallery">';
        $gallery_html .= '<h2>Galerie de la formation</h2>';
        $gallery_html .= do_shortcode('[formation_gallery]');
        $gallery_html .= '</div>';

        $content .= $gallery_html;
    }

    return $content;
}
add_filter('the_content', 'custom_add_gallery_after_content');

/**
 * Ajouter une colonne "Galerie" dans l'admin des formations
 */
function custom_formation_gallery_column($columns) {
    $columns['gallery'] = 'Galerie';
    return $columns;
}
add_filter('manage_formation_posts_columns', 'custom_formation_gallery_column');

function custom_formation_gallery_column_content($column, $post_id) {
    if ($column === 'gallery') {
        if (fg_has_gallery($post_id)) {
            $count = fg_get_gallery_count($post_id);
            echo '<span class="dashicons dashicons-images-alt2"></span> ' . $count . ' photos';
        } else {
            echo '—';
        }
    }
}
add_action('manage_formation_posts_custom_column', 'custom_formation_gallery_column_content', 10, 2);
?>
