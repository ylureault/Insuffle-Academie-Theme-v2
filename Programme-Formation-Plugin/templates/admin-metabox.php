<?php
/**
 * Template: Metabox admin pour gérer les modules
 * Variables disponibles: $modules
 */

if (!defined('ABSPATH')) exit;
?>

<div class="pfm-metabox-container">
    <div class="pfm-modules-list" id="pfm-modules-sortable">
        <?php if (!empty($modules)): ?>
            <?php foreach ($modules as $index => $module): ?>
                <div class="pfm-module-row" data-index="<?php echo esc_attr($index); ?>">
                    <div class="pfm-module-handle">
                        <span class="dashicons dashicons-menu"></span>
                    </div>

                    <div class="pfm-module-content">
                        <div class="pfm-module-header-controls">
                            <button type="button" class="pfm-toggle-module">
                                <span class="dashicons dashicons-arrow-down-alt2"></span>
                            </button>
                            <span class="pfm-module-preview">
                                <?php _e('Module', 'programme-formation'); ?>
                                <span class="pfm-module-number-preview"><?php echo esc_html($module['number'] ?? ''); ?></span>:
                                <span class="pfm-module-title-preview"><?php echo esc_html($module['title'] ?? __('Sans titre', 'programme-formation')); ?></span>
                            </span>
                            <button type="button" class="pfm-remove-module button button-link-delete">
                                <?php _e('Supprimer', 'programme-formation'); ?>
                            </button>
                        </div>

                        <div class="pfm-module-fields">
                            <div class="pfm-field-row">
                                <div class="pfm-field pfm-field-small">
                                    <label><?php _e('Numéro', 'programme-formation'); ?></label>
                                    <input type="text"
                                           name="pfm_modules[<?php echo esc_attr($index); ?>][number]"
                                           class="pfm-module-number-input"
                                           value="<?php echo esc_attr($module['number'] ?? ''); ?>"
                                           placeholder="<?php _e('1', 'programme-formation'); ?>">
                                </div>

                                <div class="pfm-field pfm-field-small">
                                    <label><?php _e('Durée', 'programme-formation'); ?></label>
                                    <input type="text"
                                           name="pfm_modules[<?php echo esc_attr($index); ?>][duree]"
                                           class="pfm-module-duree-input"
                                           value="<?php echo esc_attr($module['duree'] ?? ''); ?>"
                                           placeholder="<?php _e('3 heures', 'programme-formation'); ?>">
                                </div>

                                <div class="pfm-field pfm-field-large">
                                    <label><?php _e('Titre du module', 'programme-formation'); ?></label>
                                    <input type="text"
                                           name="pfm_modules[<?php echo esc_attr($index); ?>][title]"
                                           class="pfm-module-title-input widefat"
                                           value="<?php echo esc_attr($module['title'] ?? ''); ?>"
                                           placeholder="<?php _e('Maîtriser le principe...', 'programme-formation'); ?>">
                                </div>
                            </div>

                            <div class="pfm-field">
                                <label><?php _e('🎯 Objectif pédagogique (optionnel)', 'programme-formation'); ?></label>
                                <textarea name="pfm_modules[<?php echo esc_attr($index); ?>][objectif]"
                                          class="pfm-module-objectif-input widefat"
                                          rows="3"
                                          placeholder="<?php _e('À l\'issue de ce module, le stagiaire sera capable de...', 'programme-formation'); ?>"><?php echo esc_textarea($module['objectif'] ?? ''); ?></textarea>
                            </div>

                            <div class="pfm-field">
                                <label><?php _e('📚 Contenu du module (optionnel)', 'programme-formation'); ?></label>
                                <textarea name="pfm_modules[<?php echo esc_attr($index); ?>][content]"
                                          class="pfm-module-content-input widefat"
                                          rows="8"
                                          placeholder="<?php _e('Entrez le contenu ligne par ligne (chaque ligne aura automatiquement une coche ✓)', 'programme-formation'); ?>"><?php echo esc_textarea($module['content'] ?? ''); ?></textarea>
                                <p class="description">
                                    <?php _e('Une ligne = un point de contenu (la coche ✓ sera ajoutée automatiquement).', 'programme-formation'); ?>
                                </p>
                            </div>

                            <div class="pfm-field">
                                <label><?php _e('📋 Texte évaluation (optionnel)', 'programme-formation'); ?></label>
                                <input type="text"
                                       name="pfm_modules[<?php echo esc_attr($index); ?>][evaluation]"
                                       class="pfm-module-evaluation-input widefat"
                                       value="<?php echo esc_attr($module['evaluation'] ?? ''); ?>"
                                       placeholder="<?php _e('Évaluation Module 1', 'programme-formation'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="pfm-add-module-container">
        <button type="button" class="button button-secondary pfm-add-module">
            <span class="dashicons dashicons-plus-alt"></span>
            <?php _e('Ajouter un module', 'programme-formation'); ?>
        </button>
    </div>

    <div class="pfm-help-text">
        <p><strong><?php _e('💡 Astuce :', 'programme-formation'); ?></strong> <?php _e('Glissez-déposez pour réorganiser les modules.', 'programme-formation'); ?></p>
        <p><?php _e('✓ Chaque ligne du contenu aura automatiquement une coche devant.', 'programme-formation'); ?></p>
        <p><?php _e('Tous les champs sont optionnels.', 'programme-formation'); ?></p>
    </div>
</div>

<!-- Template pour nouveau module -->
<script type="text/template" id="pfm-module-template">
    <div class="pfm-module-row" data-index="{{INDEX}}">
        <div class="pfm-module-handle">
            <span class="dashicons dashicons-menu"></span>
        </div>

        <div class="pfm-module-content">
            <div class="pfm-module-header-controls">
                <button type="button" class="pfm-toggle-module">
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </button>
                <span class="pfm-module-preview">
                    <?php _e('Module', 'programme-formation'); ?> <span class="pfm-module-number-preview"></span>: <span class="pfm-module-title-preview"><?php _e('Nouveau module', 'programme-formation'); ?></span>
                </span>
                <button type="button" class="pfm-remove-module button button-link-delete">
                    <?php _e('Supprimer', 'programme-formation'); ?>
                </button>
            </div>

            <div class="pfm-module-fields">
                <div class="pfm-field-row">
                    <div class="pfm-field pfm-field-small">
                        <label><?php _e('Numéro', 'programme-formation'); ?></label>
                        <input type="text"
                               name="pfm_modules[{{INDEX}}][number]"
                               class="pfm-module-number-input"
                               placeholder="<?php _e('1', 'programme-formation'); ?>">
                    </div>

                    <div class="pfm-field pfm-field-small">
                        <label><?php _e('Durée', 'programme-formation'); ?></label>
                        <input type="text"
                               name="pfm_modules[{{INDEX}}][duree]"
                               class="pfm-module-duree-input"
                               placeholder="<?php _e('3 heures', 'programme-formation'); ?>">
                    </div>

                    <div class="pfm-field pfm-field-large">
                        <label><?php _e('Titre du module', 'programme-formation'); ?></label>
                        <input type="text"
                               name="pfm_modules[{{INDEX}}][title]"
                               class="pfm-module-title-input widefat"
                               placeholder="<?php _e('Maîtriser le principe...', 'programme-formation'); ?>">
                    </div>
                </div>

                <div class="pfm-field">
                    <label><?php _e('🎯 Objectif pédagogique (optionnel)', 'programme-formation'); ?></label>
                    <textarea name="pfm_modules[{{INDEX}}][objectif]"
                              class="pfm-module-objectif-input widefat"
                              rows="3"
                              placeholder="<?php _e('À l\'issue de ce module, le stagiaire sera capable de...', 'programme-formation'); ?>"></textarea>
                </div>

                <div class="pfm-field">
                    <label><?php _e('📚 Contenu du module (optionnel)', 'programme-formation'); ?></label>
                    <textarea name="pfm_modules[{{INDEX}}][content]"
                              class="pfm-module-content-input widefat"
                              rows="8"
                              placeholder="<?php _e('Entrez le contenu ligne par ligne (chaque ligne aura automatiquement une coche ✓)', 'programme-formation'); ?>"></textarea>
                    <p class="description">
                        <?php _e('Une ligne = un point de contenu (la coche ✓ sera ajoutée automatiquement).', 'programme-formation'); ?>
                    </p>
                </div>

                <div class="pfm-field">
                    <label><?php _e('📋 Texte évaluation (optionnel)', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[{{INDEX}}][evaluation]"
                           class="pfm-module-evaluation-input widefat"
                           placeholder="<?php _e('Évaluation Module 1', 'programme-formation'); ?>">
                </div>
            </div>
        </div>
    </div>
</script>

<style>
    .pfm-metabox-container {
        padding: 10px 0;
    }

    .pfm-modules-list {
        margin-bottom: 20px;
    }

    .pfm-module-row {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
        display: flex;
        transition: all 0.3s ease;
    }

    .pfm-module-row:hover {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .pfm-module-handle {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 15px 10px;
        cursor: move;
        color: #999;
        background: #f0f0f0;
        border-right: 1px solid #ddd;
    }

    .pfm-module-handle .dashicons {
        font-size: 20px;
        width: 20px;
        height: 20px;
    }

    .pfm-module-content {
        flex: 1;
        padding: 15px;
    }

    .pfm-module-header-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e0e0e0;
    }

    .pfm-toggle-module {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        color: #666;
    }

    .pfm-toggle-module:hover {
        color: #000;
    }

    .pfm-toggle-module .dashicons {
        transition: transform 0.3s;
    }

    .pfm-module-row.collapsed .pfm-toggle-module .dashicons {
        transform: rotate(-90deg);
    }

    .pfm-module-preview {
        flex: 1;
        font-weight: 600;
        color: #333;
    }

    .pfm-module-number-preview {
        color: #8E2183;
    }

    .pfm-module-title-preview {
        color: #666;
    }

    .pfm-remove-module {
        color: #b32d2e;
    }

    .pfm-module-fields {
        display: none;
    }

    .pfm-module-row:not(.collapsed) .pfm-module-fields {
        display: block;
    }

    .pfm-field-row {
        display: grid;
        grid-template-columns: 80px 150px 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .pfm-field {
        margin-bottom: 15px;
    }

    .pfm-field label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 13px;
        color: #333;
    }

    .pfm-field input[type="text"],
    .pfm-field textarea {
        width: 100%;
        padding: 8px 12px;
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
    }

    .pfm-add-module-container {
        text-align: center;
        margin: 20px 0;
    }

    .pfm-add-module {
        font-size: 14px;
        font-weight: 600;
        padding: 8px 20px;
    }

    .pfm-help-text {
        background: #e7f3ff;
        border-left: 4px solid #0073aa;
        padding: 15px;
        margin-top: 20px;
        border-radius: 4px;
    }

    .pfm-help-text p {
        margin: 5px 0;
        font-size: 13px;
    }

    .pfm-sortable-placeholder {
        background: #FFD466;
        border: 2px dashed #8E2183;
        border-radius: 4px;
        height: 100px;
        margin-bottom: 15px;
    }
</style>
