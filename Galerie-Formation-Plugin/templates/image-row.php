<?php
/**
 * Template: Ligne d'image
 * Variables: $index, $image
 */

if (!defined('ABSPATH')) exit;

$image_url = '';
if (!empty($image['image_id'])) {
    $img = wp_get_attachment_image_src($image['image_id'], 'thumbnail');
    if ($img) {
        $image_url = $img[0];
    }
}
?>

<div class="gfm-image-item" data-index="<?php echo esc_attr($index); ?>">
    <div class="gfm-image-handle">
        <span class="dashicons dashicons-menu"></span>
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

    <div class="gfm-image-content">
        <input type="hidden" name="gfm_gallery_images[<?php echo esc_attr($index); ?>][image_id]" value="<?php echo esc_attr($image['image_id'] ?? ''); ?>" class="gfm-image-id">

        <div class="gfm-image-fields">
            <div class="gfm-field">
                <label><?php _e('Titre', 'galerie-formation'); ?></label>
                <input type="text" name="gfm_gallery_images[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($image['title'] ?? ''); ?>" class="widefat" placeholder="<?php esc_attr_e('Titre de l\'image', 'galerie-formation'); ?>">
            </div>

            <div class="gfm-field">
                <label><?php _e('Description', 'galerie-formation'); ?></label>
                <textarea name="gfm_gallery_images[<?php echo esc_attr($index); ?>][description]" rows="2" class="widefat" placeholder="<?php esc_attr_e('Description...', 'galerie-formation'); ?>"><?php echo esc_textarea($image['description'] ?? ''); ?></textarea>
            </div>

            <div class="gfm-field">
                <label><?php _e('Catégorie', 'galerie-formation'); ?></label>
                <input type="text" name="gfm_gallery_images[<?php echo esc_attr($index); ?>][category]" value="<?php echo esc_attr($image['category'] ?? ''); ?>" class="widefat" placeholder="<?php esc_attr_e('Catégorie', 'galerie-formation'); ?>">
            </div>
        </div>

        <button type="button" class="button button-link-delete gfm-remove-image">
            <span class="dashicons dashicons-trash"></span>
            <?php _e('Supprimer', 'galerie-formation'); ?>
        </button>
    </div>
</div>

<style>
.gfm-image-item { background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; display: grid; grid-template-columns: 40px 120px 1fr; gap: 15px; padding: 15px; align-items: start; transition: all 0.3s; }
.gfm-image-item:hover { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.gfm-image-handle { display: flex; align-items: center; justify-content: center; cursor: move; }
.gfm-image-handle .dashicons { font-size: 24px; color: #999; }
.gfm-image-preview { width: 120px; height: 120px; border-radius: 4px; overflow: hidden; border: 2px solid #ddd; }
.gfm-image-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gfm-no-image { width: 100%; height: 100%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; }
.gfm-no-image .dashicons { font-size: 40px; color: #ccc; }
.gfm-image-content { flex: 1; }
.gfm-image-fields { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 10px; }
.gfm-field label { display: block; font-weight: 600; margin-bottom: 5px; font-size: 13px; }
.gfm-field input, .gfm-field textarea { width: 100%; }
.gfm-remove-image { color: #b32d2e; }
</style>
