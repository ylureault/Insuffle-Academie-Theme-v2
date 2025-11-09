<?php
/**
 * Gestion du shortcode pour afficher les galeries
 */

if (!defined('ABSPATH')) {
    exit;
}

class FG_Gallery_Shortcode {

    /**
     * Instance unique (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur
     */
    private function __construct() {
        add_shortcode('formation_gallery', array($this, 'render_gallery_shortcode'));
    }

    /**
     * Rendu du shortcode
     *
     * Utilisation :
     * [formation_gallery] - Affiche la galerie de la formation actuelle
     * [formation_gallery id="123"] - Affiche la galerie d'une formation spécifique
     * [formation_gallery columns="4"] - Affiche la galerie avec 4 colonnes
     * [formation_gallery style="masonry"] - Affiche en style masonry
     */
    public function render_gallery_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
            'columns' => 3,
            'size' => 'medium',
            'style' => 'grid', // grid, masonry
            'show_captions' => 'yes'
        ), $atts);

        // Récupérer les images
        $gallery_ids = get_post_meta($atts['id'], '_fg_gallery_ids', true);

        if (empty($gallery_ids) || !is_array($gallery_ids)) {
            return '<p class="fg-no-gallery">' . __('Aucune image dans la galerie.', 'formation-gallery') . '</p>';
        }

        // Récupérer les légendes
        $captions = get_post_meta($atts['id'], '_fg_gallery_captions', true);
        if (!is_array($captions)) {
            $captions = array();
        }

        // Générer un ID unique pour cette galerie
        $gallery_unique_id = 'fg-gallery-' . uniqid();

        // Construire le HTML
        ob_start();
        ?>
        <div class="fg-gallery fg-gallery-<?php echo esc_attr($atts['style']); ?> fg-columns-<?php echo esc_attr($atts['columns']); ?>"
             id="<?php echo esc_attr($gallery_unique_id); ?>">
            <?php foreach ($gallery_ids as $index => $image_id) :
                $image_url = wp_get_attachment_image_url($image_id, $atts['size']);
                $image_full_url = wp_get_attachment_image_url($image_id, 'full');
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                $caption = isset($captions[$image_id]) ? $captions[$image_id] : '';

                if (!$image_url) {
                    continue;
                }
            ?>
                <div class="fg-gallery-item" data-index="<?php echo $index; ?>">
                    <a href="<?php echo esc_url($image_full_url); ?>"
                       class="glightbox"
                       data-gallery="<?php echo esc_attr($gallery_unique_id); ?>"
                       data-glightbox="description: <?php echo esc_attr($caption); ?>">
                        <div class="fg-gallery-item-inner">
                            <img src="<?php echo esc_url($image_url); ?>"
                                 alt="<?php echo esc_attr($image_alt ? $image_alt : $caption); ?>"
                                 loading="lazy">
                            <div class="fg-gallery-overlay">
                                <span class="fg-gallery-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                    <?php if ($atts['show_captions'] === 'yes' && !empty($caption)) : ?>
                        <div class="fg-gallery-caption"><?php echo esc_html($caption); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Fonction helper pour obtenir le nombre d'images dans une galerie
     */
    public static function get_gallery_count($formation_id = null) {
        if (!$formation_id) {
            $formation_id = get_the_ID();
        }

        $gallery_ids = get_post_meta($formation_id, '_fg_gallery_ids', true);

        if (empty($gallery_ids) || !is_array($gallery_ids)) {
            return 0;
        }

        return count($gallery_ids);
    }

    /**
     * Fonction helper pour vérifier si une formation a une galerie
     */
    public static function has_gallery($formation_id = null) {
        return self::get_gallery_count($formation_id) > 0;
    }
}

/**
 * Fonctions helper pour utiliser dans les templates
 */

/**
 * Affiche la galerie d'une formation
 */
function fg_the_gallery($formation_id = null, $args = array()) {
    if (!$formation_id) {
        $formation_id = get_the_ID();
    }

    $defaults = array(
        'columns' => 3,
        'size' => 'medium',
        'style' => 'grid',
        'show_captions' => 'yes'
    );

    $args = wp_parse_args($args, $defaults);

    $shortcode = sprintf(
        '[formation_gallery id="%d" columns="%d" size="%s" style="%s" show_captions="%s"]',
        $formation_id,
        $args['columns'],
        $args['size'],
        $args['style'],
        $args['show_captions']
    );

    echo do_shortcode($shortcode);
}

/**
 * Retourne le nombre d'images dans la galerie
 */
function fg_get_gallery_count($formation_id = null) {
    return FG_Gallery_Shortcode::get_gallery_count($formation_id);
}

/**
 * Vérifie si la formation a une galerie
 */
function fg_has_gallery($formation_id = null) {
    return FG_Gallery_Shortcode::has_gallery($formation_id);
}
