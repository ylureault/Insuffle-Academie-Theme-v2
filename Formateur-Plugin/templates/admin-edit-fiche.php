<?php
/**
 * Template: Éditer une fiche formateur
 */

if (!defined('ABSPATH')) exit;

// Afficher message de succès si sauvegarde
if (isset($_GET['message']) && $_GET['message'] === 'saved') {
    echo '<div class="notice notice-success is-dismissible"><p><strong>' . __('Fiche sauvegardée avec succès !', 'fiche-formateur') . '</strong></p></div>';
}
?>

<div class="wrap ffm-edit-wrap">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-id-alt"></span>
        <?php printf(__('Éditer la fiche : %s', 'fiche-formateur'), esc_html($formateur->post_title)); ?>
    </h1>

    <a href="<?php echo admin_url('admin.php?page=fiche-formateur'); ?>" class="page-title-action">
        <span class="dashicons dashicons-arrow-left-alt2"></span>
        <?php _e('Retour à la liste', 'fiche-formateur'); ?>
    </a>

    <hr class="wp-header-end">

    <form method="post" action="" class="ffm-edit-form">
        <?php wp_nonce_field('ffm_save_fiche_' . $formateur->ID); ?>
        <input type="hidden" name="formateur_id" value="<?php echo esc_attr($formateur->ID); ?>">

        <div class="ffm-form-container">
            <!-- Section Photo -->
            <div class="ffm-section">
                <h2><span class="dashicons dashicons-format-image"></span> <?php _e('Photo du formateur', 'fiche-formateur'); ?></h2>

                <div class="ffm-photo-upload">
                    <div class="ffm-photo-preview">
                        <?php if (!empty($data['photo_id'])): ?>
                            <?php echo wp_get_attachment_image($data['photo_id'], 'medium', false, array('id' => 'ffm-photo-preview-img')); ?>
                        <?php else: ?>
                            <div id="ffm-photo-preview-img" class="ffm-no-photo">
                                <span class="dashicons dashicons-businessman"></span>
                                <p><?php _e('Aucune photo', 'fiche-formateur'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="ffm_photo_id" id="ffm-photo-id" value="<?php echo esc_attr($data['photo_id']); ?>">

                    <button type="button" class="button button-primary button-large" id="ffm-upload-photo">
                        <span class="dashicons dashicons-upload"></span>
                        <?php _e('Choisir une photo', 'fiche-formateur'); ?>
                    </button>

                    <?php if (!empty($data['photo_id'])): ?>
                        <button type="button" class="button button-secondary" id="ffm-remove-photo">
                            <span class="dashicons dashicons-no"></span>
                            <?php _e('Retirer la photo', 'fiche-formateur'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Section Informations -->
            <div class="ffm-section">
                <h2><span class="dashicons dashicons-admin-generic"></span> <?php _e('Informations principales', 'fiche-formateur'); ?></h2>

                <div class="ffm-field">
                    <label for="ffm-badge"><?php _e('Badge / Titre', 'fiche-formateur'); ?></label>
                    <input type="text"
                           name="ffm_badge"
                           id="ffm-badge"
                           class="regular-text"
                           value="<?php echo esc_attr($data['badge']); ?>"
                           placeholder="<?php esc_attr_e('Fondateur Insuffle Académie', 'fiche-formateur'); ?>">
                    <p class="description"><?php _e('Le badge affiché au-dessus du nom (optionnel)', 'fiche-formateur'); ?></p>
                </div>

                <div class="ffm-field">
                    <label for="ffm-nom"><?php _e('Nom complet', 'fiche-formateur'); ?></label>
                    <input type="text"
                           name="ffm_nom"
                           id="ffm-nom"
                           class="regular-text"
                           value="<?php echo esc_attr($data['nom']); ?>"
                           placeholder="<?php esc_attr_e('Yoan Lureault', 'fiche-formateur'); ?>">
                    <p class="description"><?php _e('Le nom du formateur (optionnel)', 'fiche-formateur'); ?></p>
                </div>

                <div class="ffm-field">
                    <label for="ffm-tagline"><?php _e('Tagline', 'fiche-formateur'); ?></label>
                    <input type="text"
                           name="ffm_tagline"
                           id="ffm-tagline"
                           class="regular-text"
                           value="<?php echo esc_attr($data['tagline']); ?>"
                           placeholder="<?php esc_attr_e('Expert en Transformation Collective', 'fiche-formateur'); ?>">
                    <p class="description"><?php _e('Une ligne d\'accroche (optionnel)', 'fiche-formateur'); ?></p>
                </div>

                <div class="ffm-field">
                    <label for="ffm-description"><?php _e('Description', 'fiche-formateur'); ?></label>
                    <textarea name="ffm_description"
                              id="ffm-description"
                              rows="5"
                              class="large-text"
                              placeholder="<?php esc_attr_e('Facilitateur et stratège de la transformation...', 'fiche-formateur'); ?>"><?php echo esc_textarea($data['description']); ?></textarea>
                    <p class="description"><?php _e('La description du formateur (optionnel, HTML autorisé avec <strong> pour mettre en jaune)', 'fiche-formateur'); ?></p>
                </div>
            </div>

            <!-- Section Stats -->
            <div class="ffm-section">
                <h2><span class="dashicons dashicons-chart-bar"></span> <?php _e('Chiffres clés (Stats)', 'fiche-formateur'); ?></h2>

                <div id="ffm-stats-list">
                    <?php if (!empty($data['stats'])): ?>
                        <?php foreach ($data['stats'] as $index => $stat): ?>
                            <?php include FFM_PLUGIN_DIR . 'templates/stat-row.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="ffm-add-stat-wrap">
                    <button type="button" class="button button-primary button-large ffm-add-stat">
                        <span class="dashicons dashicons-plus-alt"></span>
                        <?php _e('Ajouter une stat', 'fiche-formateur'); ?>
                    </button>
                </div>

                <div class="ffm-help">
                    <p><strong>💡 Astuce :</strong></p>
                    <ul>
                        <li><?php _e('Glissez-déposez pour réorganiser les stats', 'fiche-formateur'); ?></li>
                        <li><?php _e('Exemples : "15+", "500+", "2"', 'fiche-formateur'); ?></li>
                    </ul>
                </div>
            </div>

            <!-- Section Citation -->
            <div class="ffm-section">
                <h2><span class="dashicons dashicons-format-quote"></span> <?php _e('Citation', 'fiche-formateur'); ?></h2>

                <div class="ffm-field">
                    <label for="ffm-citation-texte"><?php _e('Texte de la citation', 'fiche-formateur'); ?></label>
                    <textarea name="ffm_citation_texte"
                              id="ffm-citation-texte"
                              rows="4"
                              class="large-text"
                              placeholder="<?php esc_attr_e('Le changement ne se décrète pas, il se facilite...', 'fiche-formateur'); ?>"><?php echo esc_textarea($data['citation_texte']); ?></textarea>
                    <p class="description"><?php _e('Le texte de la citation (optionnel)', 'fiche-formateur'); ?></p>
                </div>

                <div class="ffm-field">
                    <label for="ffm-citation-auteur"><?php _e('Auteur de la citation', 'fiche-formateur'); ?></label>
                    <input type="text"
                           name="ffm_citation_auteur"
                           id="ffm-citation-auteur"
                           class="regular-text"
                           value="<?php echo esc_attr($data['citation_auteur']); ?>"
                           placeholder="<?php esc_attr_e('Yoan Lureault', 'fiche-formateur'); ?>">
                    <p class="description"><?php _e('Le nom de l\'auteur (optionnel)', 'fiche-formateur'); ?></p>
                </div>
            </div>

            <!-- Boutons de sauvegarde -->
            <div class="ffm-submit-wrap">
                <button type="submit" name="ffm_save_fiche" class="button button-primary button-hero">
                    <span class="dashicons dashicons-yes"></span>
                    <?php _e('Sauvegarder la fiche', 'fiche-formateur'); ?>
                </button>

                <a href="<?php echo get_permalink($formateur->ID); ?>" class="button button-secondary button-hero" target="_blank">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php _e('Voir la page', 'fiche-formateur'); ?>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Template pour nouvelle stat -->
<script type="text/template" id="ffm-stat-template">
    <?php
    $index = '{{INDEX}}';
    $stat = array('number' => '', 'label' => '');
    include FFM_PLUGIN_DIR . 'templates/stat-row.php';
    ?>
</script>

<?php include FFM_PLUGIN_DIR . 'templates/admin-edit-styles.php'; ?>
