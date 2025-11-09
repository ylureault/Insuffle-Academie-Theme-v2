<?php
/**
 * Gestion de la galerie d'images
 */

if (!defined('ABSPATH')) {
    exit;
}

class GFM_Gallery_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_gallery'), 10, 2);
    }

    /**
     * Ajoute les metaboxes aux pages et posts
     */
    public function add_meta_boxes() {
        $post_types = array('page', 'post');

        foreach ($post_types as $post_type) {
            add_meta_box(
                'gfm_gallery_metabox',
                __('Galerie Formation - Images', 'galerie-formation'),
                array($this, 'render_metabox'),
                $post_type,
                'normal',
                'high'
            );
        }
    }

    /**
     * Affiche la metabox
     */
    public function render_metabox($post) {
        // Nonce pour la sécurité
        wp_nonce_field('gfm_save_gallery', 'gfm_gallery_nonce');

        // Récupérer les images existantes
        $images = get_post_meta($post->ID, '_gfm_gallery_images', true);
        if (empty($images)) {
            $images = array();
        }

        // Inclure le template
        include GFM_PLUGIN_DIR . 'templates/admin-metabox.php';
    }

    /**
     * Sauvegarde la galerie
     */
    public function save_gallery($post_id, $post) {
        // Vérifications de sécurité
        if (!isset($_POST['gfm_gallery_nonce']) || !wp_verify_nonce($_POST['gfm_gallery_nonce'], 'gfm_save_gallery')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Récupérer et nettoyer les données
        $images = array();

        if (isset($_POST['gfm_gallery_images']) && is_array($_POST['gfm_gallery_images'])) {
            foreach ($_POST['gfm_gallery_images'] as $image_data) {
                if (!empty($image_data['image_id'])) {
                    $images[] = array(
                        'image_id' => intval($image_data['image_id']),
                        'title' => sanitize_text_field($image_data['title'] ?? ''),
                        'description' => sanitize_textarea_field($image_data['description'] ?? ''),
                        'category' => sanitize_text_field($image_data['category'] ?? ''),
                    );
                }
            }
        }

        // Sauvegarder
        update_post_meta($post_id, '_gfm_gallery_images', $images);
    }

    /**
     * Récupère les images d'un post
     */
    public static function get_images($post_id) {
        $images = get_post_meta($post_id, '_gfm_gallery_images', true);

        if (empty($images) || !is_array($images)) {
            return array();
        }

        return $images;
    }
}
