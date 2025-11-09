<?php
/**
 * Gestion de la meta box pour les galeries de formation
 */

if (!defined('ABSPATH')) {
    exit;
}

class FG_Gallery_Metabox {

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
        add_action('add_meta_boxes', array($this, 'add_gallery_metabox'));
        add_action('save_post_formation', array($this, 'save_gallery_meta'));
    }

    /**
     * Ajoute la meta box pour la galerie
     */
    public function add_gallery_metabox() {
        add_meta_box(
            'fg_formation_gallery',
            __('Galerie photos de la formation', 'formation-gallery'),
            array($this, 'render_gallery_metabox'),
            'formation',
            'normal',
            'high'
        );
    }

    /**
     * Affiche le contenu de la meta box
     */
    public function render_gallery_metabox($post) {
        // Nonce pour la sécurité
        wp_nonce_field('fg_save_gallery_meta', 'fg_gallery_nonce');

        // Récupérer les images existantes
        $gallery_ids = get_post_meta($post->ID, '_fg_gallery_ids', true);
        if (!is_array($gallery_ids)) {
            $gallery_ids = !empty($gallery_ids) ? explode(',', $gallery_ids) : array();
        }

        // Récupérer les légendes
        $gallery_captions = get_post_meta($post->ID, '_fg_gallery_captions', true);
        if (!is_array($gallery_captions)) {
            $gallery_captions = array();
        }

        ?>
        <div class="fg-gallery-container">
            <div class="fg-gallery-toolbar">
                <button type="button" class="button button-primary fg-add-images">
                    <span class="dashicons dashicons-images-alt2"></span>
                    <?php _e('Ajouter des images', 'formation-gallery'); ?>
                </button>
                <button type="button" class="button fg-remove-all">
                    <span class="dashicons dashicons-trash"></span>
                    <?php _e('Tout supprimer', 'formation-gallery'); ?>
                </button>
            </div>

            <div class="fg-gallery-preview" id="fg-gallery-preview">
                <?php
                if (!empty($gallery_ids)) {
                    foreach ($gallery_ids as $index => $image_id) {
                        $this->render_gallery_item($image_id, $index, $gallery_captions);
                    }
                }
                ?>
            </div>

            <input type="hidden" id="fg_gallery_ids" name="fg_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">

            <p class="description">
                <?php _e('Glissez-déposez les images pour les réorganiser. Les légendes peuvent être ajoutées individuellement.', 'formation-gallery'); ?>
            </p>
        </div>

        <style>
            .fg-gallery-container {
                margin-top: 15px;
            }
            .fg-gallery-toolbar {
                margin-bottom: 15px;
                display: flex;
                gap: 10px;
            }
            .fg-gallery-preview {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
                margin-bottom: 15px;
                padding: 15px;
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 5px;
                min-height: 100px;
            }
            .fg-gallery-item {
                position: relative;
                background: white;
                border: 2px solid #ddd;
                border-radius: 5px;
                padding: 8px;
                cursor: move;
                transition: all 0.3s ease;
            }
            .fg-gallery-item:hover {
                border-color: #0073aa;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            .fg-gallery-item.ui-sortable-placeholder {
                border: 2px dashed #0073aa;
                background: #f0f0f0;
            }
            .fg-gallery-item-image {
                width: 100%;
                height: 150px;
                object-fit: cover;
                border-radius: 3px;
                display: block;
            }
            .fg-gallery-item-actions {
                position: absolute;
                top: 12px;
                right: 12px;
                display: flex;
                gap: 5px;
            }
            .fg-gallery-item-action {
                background: rgba(255, 255, 255, 0.95);
                border: none;
                border-radius: 3px;
                width: 28px;
                height: 28px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
            .fg-gallery-item-action:hover {
                background: white;
                transform: scale(1.1);
            }
            .fg-gallery-item-action.remove {
                color: #dc3232;
            }
            .fg-gallery-item-caption {
                margin-top: 8px;
            }
            .fg-gallery-item-caption input {
                width: 100%;
                padding: 5px 8px;
                border: 1px solid #ddd;
                border-radius: 3px;
                font-size: 12px;
            }
            .fg-gallery-item-caption input:focus {
                border-color: #0073aa;
                outline: none;
            }
            .fg-gallery-item-order {
                position: absolute;
                top: 12px;
                left: 12px;
                background: rgba(0, 115, 170, 0.9);
                color: white;
                border-radius: 3px;
                padding: 3px 8px;
                font-size: 11px;
                font-weight: bold;
            }
            .fg-gallery-preview:empty::after {
                content: '<?php _e('Aucune image dans la galerie. Cliquez sur "Ajouter des images" pour commencer.', 'formation-gallery'); ?>';
                display: block;
                text-align: center;
                color: #999;
                padding: 40px;
                font-style: italic;
            }
        </style>
        <?php
    }

    /**
     * Affiche un élément de galerie
     */
    private function render_gallery_item($image_id, $index, $captions) {
        $image_url = wp_get_attachment_image_url($image_id, 'medium');
        $caption = isset($captions[$image_id]) ? $captions[$image_id] : '';

        if (!$image_url) {
            return;
        }
        ?>
        <div class="fg-gallery-item" data-id="<?php echo esc_attr($image_id); ?>">
            <div class="fg-gallery-item-order"><?php echo $index + 1; ?></div>
            <div class="fg-gallery-item-actions">
                <button type="button" class="fg-gallery-item-action remove" title="<?php _e('Supprimer', 'formation-gallery'); ?>">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <img src="<?php echo esc_url($image_url); ?>" class="fg-gallery-item-image" alt="">
            <div class="fg-gallery-item-caption">
                <input type="text"
                       name="fg_gallery_captions[<?php echo esc_attr($image_id); ?>]"
                       value="<?php echo esc_attr($caption); ?>"
                       placeholder="<?php _e('Légende (optionnel)', 'formation-gallery'); ?>"
                       class="fg-caption-input">
            </div>
        </div>
        <?php
    }

    /**
     * Sauvegarde les meta données de la galerie
     */
    public function save_gallery_meta($post_id) {
        // Vérifications de sécurité
        if (!isset($_POST['fg_gallery_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['fg_gallery_nonce'], 'fg_save_gallery_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Sauvegarder les IDs des images
        if (isset($_POST['fg_gallery_ids'])) {
            $gallery_ids = sanitize_text_field($_POST['fg_gallery_ids']);
            $gallery_ids_array = array_filter(explode(',', $gallery_ids));
            update_post_meta($post_id, '_fg_gallery_ids', $gallery_ids_array);
        } else {
            delete_post_meta($post_id, '_fg_gallery_ids');
        }

        // Sauvegarder les légendes
        if (isset($_POST['fg_gallery_captions']) && is_array($_POST['fg_gallery_captions'])) {
            $captions = array();
            foreach ($_POST['fg_gallery_captions'] as $image_id => $caption) {
                $captions[intval($image_id)] = sanitize_text_field($caption);
            }
            update_post_meta($post_id, '_fg_gallery_captions', $captions);
        } else {
            delete_post_meta($post_id, '_fg_gallery_captions');
        }
    }
}
