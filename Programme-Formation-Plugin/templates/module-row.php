<?php
/**
 * Template: Ligne de module
 * Variables: $index, $module
 */

if (!defined('ABSPATH')) exit;
?>

<div class="pfm-module-item" data-index="<?php echo esc_attr($index); ?>">
    <div class="pfm-module-handle">
        <span class="dashicons dashicons-menu"></span>
    </div>

    <div class="pfm-module-content-wrap">
        <div class="pfm-module-header">
            <button type="button" class="pfm-toggle-module">
                <span class="dashicons dashicons-arrow-down-alt2"></span>
            </button>
            <span class="pfm-module-preview">
                <strong>Module <span class="pfm-preview-number"><?php echo esc_html($module['number'] ?? ''); ?></span>:</strong>
                <span class="pfm-preview-title"><?php echo esc_html($module['title'] ?? __('Nouveau module', 'programme-formation')); ?></span>
            </span>
            <button type="button" class="pfm-remove-module button button-link-delete">
                <span class="dashicons dashicons-trash"></span>
                <?php _e('Supprimer', 'programme-formation'); ?>
            </button>
        </div>

        <div class="pfm-module-fields">
            <div class="pfm-field-row-inline">
                <div class="pfm-field pfm-field-number">
                    <label><?php _e('N°', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[<?php echo esc_attr($index); ?>][number]"
                           value="<?php echo esc_attr($module['number'] ?? ''); ?>"
                           class="pfm-input-number"
                           placeholder="1">
                </div>

                <div class="pfm-field pfm-field-duree">
                    <label><?php _e('Durée', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[<?php echo esc_attr($index); ?>][duree]"
                           value="<?php echo esc_attr($module['duree'] ?? ''); ?>"
                           class="pfm-input-duree"
                           placeholder="3 heures">
                </div>

                <div class="pfm-field pfm-field-title">
                    <label><?php _e('Titre du module', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[<?php echo esc_attr($index); ?>][title]"
                           value="<?php echo esc_attr($module['title'] ?? ''); ?>"
                           class="pfm-input-title widefat"
                           placeholder="Maîtriser le principe...">
                </div>
            </div>

            <div class="pfm-field">
                <label><?php _e('🎯 Objectif pédagogique', 'programme-formation'); ?></label>
                <textarea name="pfm_modules[<?php echo esc_attr($index); ?>][objectif]"
                          class="pfm-textarea-objectif large-text"
                          rows="3"
                          placeholder="À l'issue de ce module, le stagiaire sera capable de..."><?php echo esc_textarea($module['objectif'] ?? ''); ?></textarea>
            </div>

            <div class="pfm-field">
                <label><?php _e('📚 Contenu (une ligne = un point avec ✓)', 'programme-formation'); ?></label>
                <textarea name="pfm_modules[<?php echo esc_attr($index); ?>][content]"
                          class="pfm-textarea-content large-text"
                          rows="6"
                          placeholder="Définir le Sketchnoting&#10;Identifier le matériel nécessaire&#10;Identifier les avantages..."><?php echo esc_textarea($module['content'] ?? ''); ?></textarea>
                <p class="description">Chaque ligne = un point de contenu (la coche ✓ sera ajoutée automatiquement)</p>
            </div>

            <div class="pfm-field">
                <label><?php _e('📋 Texte évaluation', 'programme-formation'); ?></label>
                <input type="text"
                       name="pfm_modules[<?php echo esc_attr($index); ?>][evaluation]"
                       value="<?php echo esc_attr($module['evaluation'] ?? ''); ?>"
                       class="pfm-input-evaluation widefat"
                       placeholder="Évaluation Module 1">
            </div>
        </div>
    </div>
</div>

<style>
.pfm-module-item {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    transition: all 0.3s;
}

.pfm-module-item:hover {
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.pfm-module-handle {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 15px;
    cursor: move;
    background: #f0f0f0;
    border-right: 1px solid #ddd;
    border-radius: 8px 0 0 8px;
}

.pfm-module-handle .dashicons {
    font-size: 24px;
    color: #999;
}

.pfm-module-content-wrap {
    flex: 1;
    padding: 20px;
}

.pfm-module-header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e0e0e0;
    margin-bottom: 20px;
}

.pfm-toggle-module {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.pfm-toggle-module .dashicons {
    font-size: 20px;
    color: #666;
    transition: transform 0.3s;
}

.pfm-module-item.collapsed .pfm-toggle-module .dashicons {
    transform: rotate(-90deg);
}

.pfm-module-preview {
    flex: 1;
    font-size: 15px;
}

.pfm-preview-number {
    color: #8E2183;
    font-weight: 700;
}

.pfm-remove-module {
    color: #b32d2e;
}

.pfm-module-fields {
    display: none;
}

.pfm-module-item:not(.collapsed) .pfm-module-fields {
    display: block;
}

.pfm-field-row-inline {
    display: grid;
    grid-template-columns: 80px 150px 1fr;
    gap: 15px;
    margin-bottom: 20px;
}

.pfm-field {
    margin-bottom: 20px;
}

.pfm-field label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
}

.pfm-field input[type="text"],
.pfm-field textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.pfm-field input[type="text"]:focus,
.pfm-field textarea:focus {
    border-color: #8E2183;
    outline: none;
    box-shadow: 0 0 0 1px #8E2183;
}

.pfm-field textarea {
    resize: vertical;
    font-family: inherit;
}

.pfm-field .description {
    margin-top: 5px;
    font-size: 12px;
    color: #666;
    font-style: italic;
}

.pfm-sortable-placeholder {
    background: #FFD466;
    border: 2px dashed #8E2183;
    border-radius: 8px;
    height: 150px;
    margin-bottom: 20px;
}
</style>
