<?php
/**
 * Template de la metabox pour les informations pratiques
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="pfm-infos-container">
    <p class="description">
        <?php _e('Ces informations seront affichées à la fin du programme de formation.', 'programme-formation'); ?>
    </p>

    <!-- Méthodes pédagogiques -->
    <div class="pfm-info-field">
        <label for="pfm-methodes">
            <strong>🎯 <?php _e('Méthodes pédagogiques', 'programme-formation'); ?></strong>
            <span class="pfm-optional">(<?php _e('optionnel - HTML autorisé', 'programme-formation'); ?>)</span>
        </label>
        <textarea id="pfm-methodes"
                  name="pfm_methodes"
                  rows="4"
                  class="pfm-textarea"
                  placeholder="<?php _e('Ex: Alternance d\'apports théoriques et d\'exercices pratiques...', 'programme-formation'); ?>"><?php echo esc_textarea($infos['methodes']); ?></textarea>
        <p class="description">
            <?php _e('Décrivez les méthodes pédagogiques utilisées.', 'programme-formation'); ?>
        </p>
    </div>

    <!-- Moyens techniques -->
    <div class="pfm-info-field">
        <label for="pfm-moyens">
            <strong>🛠️ <?php _e('Moyens techniques', 'programme-formation'); ?></strong>
            <span class="pfm-optional">(<?php _e('optionnel - HTML autorisé', 'programme-formation'); ?>)</span>
        </label>
        <textarea id="pfm-moyens"
                  name="pfm_moyens"
                  rows="6"
                  class="pfm-textarea"
                  placeholder="<?php _e('Ex: Supports visuels projetés, Paperboards, Feutres, Tablettes...', 'programme-formation'); ?>"><?php echo esc_textarea($infos['moyens']); ?></textarea>
        <p class="description">
            <?php _e('Listez les moyens techniques utilisés (vous pouvez utiliser une liste HTML <ul><li>).', 'programme-formation'); ?>
        </p>
    </div>

    <!-- Modalités d'évaluation -->
    <div class="pfm-info-field">
        <label for="pfm-evaluation">
            <strong>✅ <?php _e('Modalités d\'évaluation', 'programme-formation'); ?></strong>
            <span class="pfm-optional">(<?php _e('optionnel - HTML autorisé', 'programme-formation'); ?>)</span>
        </label>
        <textarea id="pfm-evaluation"
                  name="pfm_evaluation"
                  rows="4"
                  class="pfm-textarea"
                  placeholder="<?php _e('Ex: Évaluation continue au fil des modules...', 'programme-formation'); ?>"><?php echo esc_textarea($infos['evaluation']); ?></textarea>
        <p class="description">
            <?php _e('Décrivez les modalités d\'évaluation de la formation.', 'programme-formation'); ?>
        </p>
    </div>

</div>

<style>
.pfm-infos-container {
    padding: 15px;
}

.pfm-info-field {
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid #e0e0e0;
}

.pfm-info-field:last-child {
    border-bottom: none;
}

.pfm-info-field label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
}

.pfm-textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
    font-size: 14px;
    resize: vertical;
}

.pfm-textarea:focus {
    border-color: #8E2183;
    outline: none;
    box-shadow: 0 0 0 1px #8E2183;
}

.pfm-optional {
    font-weight: normal;
    font-style: italic;
    color: #666;
    font-size: 12px;
}

.pfm-infos-container .description {
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}
</style>
