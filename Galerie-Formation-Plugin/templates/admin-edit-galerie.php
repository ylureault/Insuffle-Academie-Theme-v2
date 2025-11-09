<?php
/**
 * Template: Éditer une galerie
 */

if (!defined('ABSPATH')) exit;

// Afficher message de succès
if (isset($_GET['message']) && $_GET['message'] === 'saved') {
    echo '<div class="notice notice-success is-dismissible"><p><strong>' . __('Galerie sauvegardée avec succès !', 'galerie-formation') . '</strong></p></div>';
}
?>

<div class="wrap gfm-edit-wrap">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-format-gallery"></span>
        <?php printf(__('Éditer la galerie : %s', 'galerie-formation'), esc_html($formation->post_title)); ?>
    </h1>

    <a href="<?php echo admin_url('admin.php?page=galerie-formation'); ?>" class="page-title-action">
        <span class="dashicons dashicons-arrow-left-alt2"></span>
        <?php _e('Retour à la liste', 'galerie-formation'); ?>
    </a>

    <hr class="wp-header-end">

    <form method="post" action="" class="gfm-edit-form">
        <?php wp_nonce_field('gfm_save_galerie_' . $formation->ID); ?>
        <input type="hidden" name="formation_id" value="<?php echo esc_attr($formation->ID); ?>">

        <div class="gfm-form-container">
            <div class="gfm-section">
                <h2><span class="dashicons dashicons-images-alt2"></span> <?php _e('Images de la galerie', 'galerie-formation'); ?></h2>

                <div id="gfm-images-list">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $index => $image): ?>
                            <?php include GFM_PLUGIN_DIR . 'templates/image-row.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="gfm-add-image-wrap">
                    <button type="button" class="button button-primary button-large gfm-add-images">
                        <span class="dashicons dashicons-plus-alt"></span>
                        <?php _e('Ajouter des images', 'galerie-formation'); ?>
                    </button>
                </div>

                <div class="gfm-help">
                    <p><strong>💡 Astuce :</strong></p>
                    <ul>
                        <li><?php _e('Glissez-déposez pour réorganiser les images', 'galerie-formation'); ?></li>
                        <li><?php _e('Vous pouvez sélectionner plusieurs images en même temps', 'galerie-formation'); ?></li>
                        <li><?php _e('Tous les champs sont optionnels', 'galerie-formation'); ?></li>
                    </ul>
                </div>
            </div>

            <div class="gfm-submit-wrap">
                <button type="submit" name="gfm_save_galerie" class="button button-primary button-hero">
                    <span class="dashicons dashicons-yes"></span>
                    <?php _e('Sauvegarder la galerie', 'galerie-formation'); ?>
                </button>

                <a href="<?php echo get_permalink($formation->ID); ?>" class="button button-secondary button-hero" target="_blank">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php _e('Voir la page', 'galerie-formation'); ?>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Template pour nouvelle image -->
<script type="text/template" id="gfm-image-template">
    <?php
    $index = '{{INDEX}}';
    $image = array('image_id' => '', 'title' => '', 'description' => '', 'category' => '');
    include GFM_PLUGIN_DIR . 'templates/image-row.php';
    ?>
</script>

<style>
.gfm-edit-wrap { margin: 20px 20px 0 0; }
.gfm-edit-wrap h1 { display: flex; align-items: center; gap: 10px; }
.gfm-edit-wrap h1 .dashicons { font-size: 32px; width: 32px; height: 32px; color: #8E2183; }
.gfm-form-container { max-width: 1200px; }
.gfm-section { background: white; border-radius: 8px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.gfm-section h2 { display: flex; align-items: center; gap: 10px; color: #8E2183; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f1; }
.gfm-section h2 .dashicons { font-size: 24px; width: 24px; height: 24px; }
#gfm-images-list { margin-bottom: 20px; }
.gfm-add-image-wrap { text-align: center; margin: 20px 0; }
.gfm-help { background: #e7f3ff; border-left: 4px solid #0073aa; padding: 15px 20px; margin-top: 20px; }
.gfm-help ul { margin: 10px 0 0 20px; }
.gfm-submit-wrap { background: #f0f0f1; padding: 20px; margin-top: 30px; border-top: 1px solid #c3c4c7; text-align: center; }
.gfm-submit-wrap .button { margin: 0 10px; }
.gfm-sortable-placeholder { background: #FFD466; border: 2px dashed #8E2183; border-radius: 8px; height: 120px; margin-bottom: 15px; }
</style>
