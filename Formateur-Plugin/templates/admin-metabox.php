<?php
/**
 * Template de la metabox admin pour la fiche formateur
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="ffm-metabox-container">

    <!-- Photo du formateur -->
    <div class="ffm-field-group">
        <label class="ffm-label">
            <?php _e('Photo du formateur', 'fiche-formateur'); ?>
        </label>
        <div class="ffm-photo-upload">
            <input type="hidden" name="ffm_photo_id" id="ffm-photo-id" value="<?php echo esc_attr($formateur_data['photo_id']); ?>">
            <div class="ffm-photo-preview" id="ffm-photo-preview">
                <?php if (!empty($formateur_data['photo_id'])): ?>
                    <?php echo wp_get_attachment_image($formateur_data['photo_id'], 'medium'); ?>
                <?php else: ?>
                    <div class="ffm-photo-placeholder">
                        <span class="dashicons dashicons-format-image"></span>
                        <p><?php _e('Aucune photo sélectionnée', 'fiche-formateur'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="ffm-photo-buttons">
                <button type="button" class="button button-primary ffm-upload-photo">
                    <span class="dashicons dashicons-upload"></span>
                    <?php _e('Choisir une photo', 'fiche-formateur'); ?>
                </button>
                <button type="button" class="button ffm-remove-photo" <?php echo empty($formateur_data['photo_id']) ? 'style="display:none;"' : ''; ?>>
                    <span class="dashicons dashicons-no"></span>
                    <?php _e('Retirer', 'fiche-formateur'); ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Badge -->
    <div class="ffm-field-group">
        <label class="ffm-label" for="ffm-badge">
            <?php _e('Badge / Titre', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel', 'fiche-formateur'); ?>)</span>
        </label>
        <input type="text"
               id="ffm-badge"
               name="ffm_badge"
               class="ffm-input"
               value="<?php echo esc_attr($formateur_data['badge']); ?>"
               placeholder="<?php _e('Ex: Fondateur Insuffle Académie', 'fiche-formateur'); ?>">
    </div>

    <!-- Nom -->
    <div class="ffm-field-group">
        <label class="ffm-label" for="ffm-nom">
            <?php _e('Nom du formateur', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel', 'fiche-formateur'); ?>)</span>
        </label>
        <input type="text"
               id="ffm-nom"
               name="ffm_nom"
               class="ffm-input"
               value="<?php echo esc_attr($formateur_data['nom']); ?>"
               placeholder="<?php _e('Ex: Yoan Lureault', 'fiche-formateur'); ?>">
    </div>

    <!-- Tagline -->
    <div class="ffm-field-group">
        <label class="ffm-label" for="ffm-tagline">
            <?php _e('Tagline / Sous-titre', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel', 'fiche-formateur'); ?>)</span>
        </label>
        <input type="text"
               id="ffm-tagline"
               name="ffm_tagline"
               class="ffm-input"
               value="<?php echo esc_attr($formateur_data['tagline']); ?>"
               placeholder="<?php _e('Ex: Expert en Transformation Collective', 'fiche-formateur'); ?>">
    </div>

    <!-- Description -->
    <div class="ffm-field-group">
        <label class="ffm-label" for="ffm-description">
            <?php _e('Description / Biographie', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel - HTML autorisé', 'fiche-formateur'); ?>)</span>
        </label>
        <textarea id="ffm-description"
                  name="ffm_description"
                  class="ffm-textarea"
                  rows="5"
                  placeholder="<?php _e('Décrivez le parcours et l\'expertise du formateur...', 'fiche-formateur'); ?>"><?php echo esc_textarea($formateur_data['description']); ?></textarea>
    </div>

    <!-- Stats / Chiffres clés -->
    <div class="ffm-field-group">
        <label class="ffm-label">
            <?php _e('Chiffres clés / Statistiques', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel', 'fiche-formateur'); ?>)</span>
        </label>
        <div id="ffm-stats-container">
            <?php if (!empty($formateur_data['stats'])): ?>
                <?php foreach ($formateur_data['stats'] as $index => $stat): ?>
                    <div class="ffm-stat-item" data-index="<?php echo esc_attr($index); ?>">
                        <div class="ffm-stat-handle">
                            <span class="dashicons dashicons-menu"></span>
                        </div>
                        <div class="ffm-stat-fields">
                            <input type="text"
                                   name="ffm_stats[<?php echo esc_attr($index); ?>][number]"
                                   class="ffm-stat-number"
                                   value="<?php echo esc_attr($stat['number']); ?>"
                                   placeholder="<?php _e('Ex: 15+', 'fiche-formateur'); ?>">
                            <input type="text"
                                   name="ffm_stats[<?php echo esc_attr($index); ?>][label]"
                                   class="ffm-stat-label"
                                   value="<?php echo esc_attr($stat['label']); ?>"
                                   placeholder="<?php _e('Ex: Années d\'expérience', 'fiche-formateur'); ?>">
                        </div>
                        <button type="button" class="button ffm-remove-stat">
                            <span class="dashicons dashicons-trash"></span>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button ffm-add-stat">
            <span class="dashicons dashicons-plus-alt"></span>
            <?php _e('Ajouter un chiffre clé', 'fiche-formateur'); ?>
        </button>
    </div>

    <!-- Citation -->
    <div class="ffm-field-group">
        <label class="ffm-label" for="ffm-citation-texte">
            <?php _e('Citation / Devise', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel', 'fiche-formateur'); ?>)</span>
        </label>
        <textarea id="ffm-citation-texte"
                  name="ffm_citation_texte"
                  class="ffm-textarea"
                  rows="3"
                  placeholder="<?php _e('Ex: Le changement ne se décrète pas, il se facilite...', 'fiche-formateur'); ?>"><?php echo esc_textarea($formateur_data['citation_texte']); ?></textarea>
    </div>

    <!-- Auteur de la citation -->
    <div class="ffm-field-group">
        <label class="ffm-label" for="ffm-citation-auteur">
            <?php _e('Auteur de la citation', 'fiche-formateur'); ?>
            <span class="ffm-optional">(<?php _e('optionnel', 'fiche-formateur'); ?>)</span>
        </label>
        <input type="text"
               id="ffm-citation-auteur"
               name="ffm_citation_auteur"
               class="ffm-input"
               value="<?php echo esc_attr($formateur_data['citation_auteur']); ?>"
               placeholder="<?php _e('Ex: Yoan Lureault', 'fiche-formateur'); ?>">
    </div>

</div>

<!-- Template pour les stats -->
<script type="text/html" id="ffm-stat-template">
    <div class="ffm-stat-item" data-index="{{INDEX}}">
        <div class="ffm-stat-handle">
            <span class="dashicons dashicons-menu"></span>
        </div>
        <div class="ffm-stat-fields">
            <input type="text"
                   name="ffm_stats[{{INDEX}}][number]"
                   class="ffm-stat-number"
                   placeholder="<?php _e('Ex: 15+', 'fiche-formateur'); ?>">
            <input type="text"
                   name="ffm_stats[{{INDEX}}][label]"
                   class="ffm-stat-label"
                   placeholder="<?php _e('Ex: Années d\'expérience', 'fiche-formateur'); ?>">
        </div>
        <button type="button" class="button ffm-remove-stat">
            <span class="dashicons dashicons-trash"></span>
        </button>
    </div>
</script>
