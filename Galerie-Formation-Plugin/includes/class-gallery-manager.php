<?php
/**
 * Gestion des données de la galerie
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
        // Hook pour sauvegarder depuis l'admin
        add_action('admin_init', array($this, 'handle_save'));
    }

    /**
     * Gère la sauvegarde depuis le formulaire admin
     */
    public function handle_save() {
        if (!isset($_POST['gfm_save_galerie'])) {
            return;
        }

        $formation_id = isset($_POST['formation_id']) ? intval($_POST['formation_id']) : 0;

        if (!$formation_id) {
            return;
        }

        // Vérifier le nonce
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'gfm_save_galerie_' . $formation_id)) {
            return;
        }

        // Vérifier les permissions
        if (!current_user_can('edit_post', $formation_id)) {
            return;
        }

        // Sauvegarder les images
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

        // Sauvegarder dans post_meta
        update_post_meta($formation_id, '_gfm_gallery_images', $images);

        // Rediriger avec message de succès
        wp_redirect(add_query_arg(
            array(
                'page' => 'gfm-edit-galerie',
                'formation_id' => $formation_id,
                'message' => 'saved'
            ),
            admin_url('admin.php')
        ));
        exit;
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
