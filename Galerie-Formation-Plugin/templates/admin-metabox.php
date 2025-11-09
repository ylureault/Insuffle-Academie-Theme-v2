<?php
/**
 * Template: Metabox admin pour gérer la galerie
 * Variables disponibles: $images
 */

if (!defined('ABSPATH')) exit;
?>

<div class="gfm-metabox-container">
    <div class="gfm-images-list" id="gfm-images-sortable">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $index => $image): ?>
                <?php
                $image_url = wp_get_attachment_image_url($image['image_id'], 'thumbnail');
                ?>
                <div class="gfm-image-item" data-index="<?php echo $index; ?>">
                    <div class="gfm-image-handle">
                        <span class="dashicons dashicons-move"></span>
                    </div>

                    <div class="gfm-image-preview">
                        <?php if ($image_url): ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                        <?php else: ?>
                            <div class="gfm-no-image">
                                <span class="dashicons dashicons-format-image"></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="gfm-image-fields">
                        <input type="hidden"
                               name="gfm_gallery_images[<?php echo $index; ?>][image_id]"
                               class="gfm-image-id"
                               value="<?php echo esc_attr($image['image_id']); ?>">

                        <div class="gfm-field">
                            <label><?php _e('Titre (optionnel)', 'galerie-formation'); ?></label>
                            <input type="text"
                                   name="gfm_gallery_images[<?php echo $index; ?>][title]"
                                   value="<?php echo esc_attr($image['title'] ?? ''); ?>"
                                   placeholder="<?php _e('Ex: Formation Sketchnote', 'galerie-formation'); ?>">
                        </div>

                        <div class="gfm-field">
                            <label><?php _e('Description (optionnel)', 'galerie-formation'); ?></label>
                            <textarea name="gfm_gallery_images[<?php echo $index; ?>][description]"
                                      rows="2"
                                      placeholder="<?php _e('Description de l\'image...', 'galerie-formation'); ?>"><?php echo esc_textarea($image['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="gfm-field">
                            <label><?php _e('Catégorie (optionnel)', 'galerie-formation'); ?></label>
                            <input type="text"
                                   name="gfm_gallery_images[<?php echo $index; ?>][category]"
                                   value="<?php echo esc_attr($image['category'] ?? ''); ?>"
                                   placeholder="<?php _e('Ex: sketchnote, facilitation...', 'galerie-formation'); ?>">
                        </div>
                    </div>

                    <div class="gfm-image-actions">
                        <button type="button" class="button gfm-change-image">
                            <?php _e('Changer', 'galerie-formation'); ?>
                        </button>
                        <button type="button" class="button button-link-delete gfm-remove-image">
                            <?php _e('Supprimer', 'galerie-formation'); ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="gfm-add-image-container">
        <button type="button" class="button button-primary gfm-add-image">
            <span class="dashicons dashicons-plus-alt"></span>
            <?php _e('Ajouter une image', 'galerie-formation'); ?>
        </button>
    </div>

    <div class="gfm-help-text">
        <p><strong><?php _e('💡 Astuce :', 'galerie-formation'); ?></strong> <?php _e('Vous pouvez réorganiser les images par glisser-déposer.', 'galerie-formation'); ?></p>
        <p><?php _e('Tous les champs sont optionnels sauf l\'image elle-même.', 'galerie-formation'); ?></p>
    </div>
</div>

<!-- Template pour nouvelle image -->
<script type="text/template" id="gfm-image-template">
    <div class="gfm-image-item" data-index="{{INDEX}}">
        <div class="gfm-image-handle">
            <span class="dashicons dashicons-move"></span>
        </div>

        <div class="gfm-image-preview">
            <div class="gfm-no-image">
                <span class="dashicons dashicons-format-image"></span>
            </div>
        </div>

        <div class="gfm-image-fields">
            <input type="hidden"
                   name="gfm_gallery_images[{{INDEX}}][image_id]"
                   class="gfm-image-id"
                   value="">

            <div class="gfm-field">
                <label><?php _e('Titre (optionnel)', 'galerie-formation'); ?></label>
                <input type="text"
                       name="gfm_gallery_images[{{INDEX}}][title]"
                       value=""
                       placeholder="<?php _e('Ex: Formation Sketchnote', 'galerie-formation'); ?>">
            </div>

            <div class="gfm-field">
                <label><?php _e('Description (optionnel)', 'galerie-formation'); ?></label>
                <textarea name="gfm_gallery_images[{{INDEX}}][description]"
                          rows="2"
                          placeholder="<?php _e('Description de l\'image...', 'galerie-formation'); ?>"></textarea>
            </div>

            <div class="gfm-field">
                <label><?php _e('Catégorie (optionnel)', 'galerie-formation'); ?></label>
                <input type="text"
                       name="gfm_gallery_images[{{INDEX}}][category]"
                       value=""
                       placeholder="<?php _e('Ex: sketchnote, facilitation...', 'galerie-formation'); ?>">
            </div>
        </div>

        <div class="gfm-image-actions">
            <button type="button" class="button gfm-change-image">
                <?php _e('Changer', 'galerie-formation'); ?>
            </button>
            <button type="button" class="button button-link-delete gfm-remove-image">
                <?php _e('Supprimer', 'galerie-formation'); ?>
            </button>
        </div>
    </div>
</script>

<style>
    .gfm-metabox-container {
        padding: 10px 0;
    }

    .gfm-images-list {
        margin-bottom: 20px;
    }

    .gfm-image-item {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .gfm-image-item.ui-sortable-helper {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .gfm-image-handle {
        cursor: move;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8E2183;
    }

    .gfm-image-handle .dashicons {
        font-size: 20px;
    }

    .gfm-image-preview {
        width: 100px;
        height: 100px;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gfm-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gfm-no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: #f0f0f0;
    }

    .gfm-no-image .dashicons {
        font-size: 40px;
        color: #ccc;
    }

    .gfm-image-fields {
        flex: 1;
    }

    .gfm-field {
        margin-bottom: 10px;
    }

    .gfm-field:last-child {
        margin-bottom: 0;
    }

    .gfm-field label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
        font-size: 12px;
    }

    .gfm-field input[type="text"],
    .gfm-field textarea {
        width: 100%;
        padding: 6px 8px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 13px;
    }

    .gfm-image-actions {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .gfm-add-image-container {
        text-align: center;
        padding: 20px;
        background: #f0f0f0;
        border: 2px dashed #ddd;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .gfm-add-image {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .gfm-help-text {
        background: #e7f3ff;
        border-left: 4px solid #0073aa;
        padding: 15px;
        border-radius: 4px;
    }

    .gfm-help-text p {
        margin: 5px 0;
    }

    .gfm-sortable-placeholder {
        background: #f0f0f0;
        border: 2px dashed #ddd;
        border-radius: 4px;
        height: 130px;
        margin-bottom: 15px;
    }
</style>
