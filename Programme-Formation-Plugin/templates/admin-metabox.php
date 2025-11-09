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
                <?php $this->render_module_row($module, $index); ?>
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
        <p><strong><?php _e('💡 Astuce :', 'programme-formation'); ?></strong> <?php _e('Vous pouvez réorganiser les modules par glisser-déposer.', 'programme-formation'); ?></p>
        <p><?php _e('Tous les champs sont optionnels. Laissez vide les champs que vous ne souhaitez pas afficher.', 'programme-formation'); ?></p>
    </div>
</div>

<!-- Template pour nouveau module -->
<script type="text/template" id="pfm-module-template">
    <div class="pfm-module-row">
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
                <div class="pfm-field">
                    <label><?php _e('Numéro du module (optionnel)', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[{{INDEX}}][number]"
                           class="pfm-module-number-input"
                           placeholder="<?php _e('Ex: 1, 2, 3...', 'programme-formation'); ?>">
                </div>

                <div class="pfm-field">
                    <label><?php _e('Titre du module (optionnel)', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[{{INDEX}}][title]"
                           class="pfm-module-title-input widefat"
                           placeholder="<?php _e('Ex: Le principe du Sketchnoting', 'programme-formation'); ?>">
                </div>

                <div class="pfm-field">
                    <label><?php _e('Contenu du module (optionnel - HTML autorisé)', 'programme-formation'); ?></label>
                    <textarea name="pfm_modules[{{INDEX}}][content]"
                              class="pfm-module-content-input widefat"
                              rows="10"
                              placeholder="<?php _e('Ajoutez le contenu HTML...', 'programme-formation'); ?>"></textarea>
                    <p class="description">
                        <?php _e('Vous pouvez utiliser du HTML : &lt;h4&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, etc.', 'programme-formation'); ?>
                        <br><?php _e('Utilisez la classe "pfm-quote-block" pour créer un encadré.', 'programme-formation'); ?>
                    </p>
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

    .pfm-module-row.ui-sortable-helper {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .pfm-module-handle {
        width: 40px;
        background: #8E2183;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: move;
        border-radius: 4px 0 0 4px;
    }

    .pfm-module-handle .dashicons {
        color: white;
        font-size: 20px;
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
        border-bottom: 1px solid #ddd;
    }

    .pfm-toggle-module {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .pfm-toggle-module .dashicons {
        font-size: 20px;
        color: #666;
    }

    .pfm-module-row.pfm-collapsed .pfm-toggle-module {
        transform: rotate(-90deg);
    }

    .pfm-module-row.pfm-collapsed .pfm-module-fields {
        display: none;
    }

    .pfm-module-preview {
        flex: 1;
        font-weight: 600;
        color: #333;
    }

    .pfm-module-number-preview {
        display: inline-block;
        min-width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        background: #8E2183;
        color: white;
        border-radius: 50%;
        font-size: 14px;
    }

    .pfm-module-title-preview {
        color: #8E2183;
    }

    .pfm-remove-module {
        color: #a00;
        text-decoration: none;
    }

    .pfm-remove-module:hover {
        color: #dc3232;
    }

    .pfm-module-fields {
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pfm-field {
        margin-bottom: 15px;
    }

    .pfm-field label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .pfm-field input[type="text"],
    .pfm-field textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: monospace;
    }

    .pfm-field textarea {
        font-size: 13px;
        line-height: 1.6;
    }

    .pfm-field .description {
        margin-top: 5px;
        font-style: italic;
        color: #666;
        font-size: 12px;
    }

    .pfm-add-module-container {
        text-align: center;
        padding: 20px;
        background: #f0f0f0;
        border: 2px dashed #ddd;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .pfm-add-module {
        font-size: 14px;
        padding: 10px 20px;
    }

    .pfm-add-module .dashicons {
        margin-right: 5px;
    }

    .pfm-help-text {
        background: #e7f3ff;
        border-left: 4px solid #0073aa;
        padding: 15px;
        border-radius: 4px;
    }

    .pfm-help-text p {
        margin: 5px 0;
    }
</style>

<?php
// Fonction helper pour afficher une ligne de module
function render_module_row($module, $index) {
    ?>
    <div class="pfm-module-row">
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
                    <?php if (!empty($module['number'])): ?>
                        <span class="pfm-module-number-preview"><?php echo esc_html($module['number']); ?></span>
                    <?php else: ?>
                        <span class="pfm-module-number-preview">-</span>
                    <?php endif; ?>
                    :
                    <span class="pfm-module-title-preview">
                        <?php echo !empty($module['title']) ? esc_html($module['title']) : __('(Sans titre)', 'programme-formation'); ?>
                    </span>
                </span>
                <button type="button" class="pfm-remove-module button button-link-delete">
                    <?php _e('Supprimer', 'programme-formation'); ?>
                </button>
            </div>

            <div class="pfm-module-fields">
                <div class="pfm-field">
                    <label><?php _e('Numéro du module (optionnel)', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[<?php echo $index; ?>][number]"
                           class="pfm-module-number-input"
                           value="<?php echo esc_attr($module['number'] ?? ''); ?>"
                           placeholder="<?php _e('Ex: 1, 2, 3...', 'programme-formation'); ?>">
                </div>

                <div class="pfm-field">
                    <label><?php _e('Titre du module (optionnel)', 'programme-formation'); ?></label>
                    <input type="text"
                           name="pfm_modules[<?php echo $index; ?>][title]"
                           class="pfm-module-title-input widefat"
                           value="<?php echo esc_attr($module['title'] ?? ''); ?>"
                           placeholder="<?php _e('Ex: Le principe du Sketchnoting', 'programme-formation'); ?>">
                </div>

                <div class="pfm-field">
                    <label><?php _e('Contenu du module (optionnel - HTML autorisé)', 'programme-formation'); ?></label>
                    <textarea name="pfm_modules[<?php echo $index; ?>][content]"
                              class="pfm-module-content-input widefat"
                              rows="10"
                              placeholder="<?php _e('Ajoutez le contenu HTML...', 'programme-formation'); ?>"><?php echo esc_textarea($module['content'] ?? ''); ?></textarea>
                    <p class="description">
                        <?php _e('Vous pouvez utiliser du HTML : &lt;h4&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, etc.', 'programme-formation'); ?>
                        <br><?php _e('Utilisez la classe "pfm-quote-block" pour créer un encadré.', 'programme-formation'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
