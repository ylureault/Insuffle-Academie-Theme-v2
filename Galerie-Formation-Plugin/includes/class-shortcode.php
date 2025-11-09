<?php
/**
 * Gestion du shortcode pour afficher la galerie
 */

if (!defined('ABSPATH')) {
    exit;
}

class GFM_Shortcode {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('galerie_formation', array($this, 'render_shortcode'));
    }

    /**
     * Rendu du shortcode
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'post_id' => get_the_ID(),
            'category' => '',
            'columns' => '3',
            'titre' => '',
            'sous_titre' => '',
            'description' => '',
        ), $atts, 'galerie_formation');

        $post_id = intval($atts['post_id']);
        $category = sanitize_text_field($atts['category']);
        $columns = intval($atts['columns']);

        // Récupérer les images
        $images = GFM_Gallery_Manager::get_images($post_id);

        // Filtrer par catégorie si spécifiée
        if (!empty($category) && !empty($images)) {
            $images = array_filter($images, function($image) use ($category) {
                return !empty($image['category']) && $image['category'] === $category;
            });
        }

        if (empty($images)) {
            return '<div class="gfm-notice">' . __('Aucune image dans la galerie.', 'galerie-formation') . '</div>';
        }

        // Générer le HTML
        ob_start();
        $this->render_gallery($images, $atts);
        return ob_get_clean();
    }

    /**
     * Affiche la galerie
     */
    private function render_gallery($images, $atts) {
        $columns = intval($atts['columns']);
        ?>
        <section class="gfm-gallery-section">
            <div class="gfm-gallery-container">
                <?php if (!empty($atts['sous_titre'])): ?>
                    <div class="gfm-section-subtitle"><?php echo esc_html($atts['sous_titre']); ?></div>
                <?php endif; ?>

                <?php if (!empty($atts['titre'])): ?>
                    <h2 class="gfm-section-title"><?php echo esc_html($atts['titre']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($atts['description'])): ?>
                    <p class="gfm-section-description"><?php echo esc_html($atts['description']); ?></p>
                <?php endif; ?>

                <div class="gfm-image-grid gfm-columns-<?php echo esc_attr($columns); ?>">
                    <?php foreach ($images as $image): ?>
                        <?php $this->render_image_item($image); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    /**
     * Affiche un item de la galerie
     */
    private function render_image_item($image) {
        $image_id = $image['image_id'];
        $image_url = wp_get_attachment_image_url($image_id, 'large');
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

        if (!$image_url) {
            return;
        }

        // Utiliser le titre de l'image ou le titre personnalisé
        $title = !empty($image['title']) ? $image['title'] : get_the_title($image_id);
        $alt = !empty($image_alt) ? $image_alt : $title;
        ?>
        <div class="gfm-gallery-item">
            <img src="<?php echo esc_url($image_url); ?>"
                 alt="<?php echo esc_attr($alt); ?>"
                 loading="lazy"
                 class="gfm-gallery-image">

            <?php if (!empty($image['title']) || !empty($image['description'])): ?>
                <div class="gfm-gallery-overlay">
                    <?php if (!empty($image['title'])): ?>
                        <div class="gfm-gallery-title"><?php echo esc_html($image['title']); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($image['description'])): ?>
                        <div class="gfm-gallery-description"><?php echo esc_html($image['description']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
