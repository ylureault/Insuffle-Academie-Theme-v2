<?php
/**
 * Template: Ligne de stat
 * Variables: $index, $stat
 */

if (!defined('ABSPATH')) exit;
?>

<div class="ffm-stat-item" data-index="<?php echo esc_attr($index); ?>">
    <div class="ffm-stat-handle">
        <span class="dashicons dashicons-menu"></span>
    </div>

    <div class="ffm-stat-content">
        <div class="ffm-stat-fields">
            <div class="ffm-field ffm-field-number">
                <label><?php _e('Chiffre', 'fiche-formateur'); ?></label>
                <input type="text"
                       name="ffm_stats[<?php echo esc_attr($index); ?>][number]"
                       value="<?php echo esc_attr($stat['number'] ?? ''); ?>"
                       class="ffm-stat-number-input"
                       placeholder="15+">
            </div>

            <div class="ffm-field ffm-field-label">
                <label><?php _e('Label', 'fiche-formateur'); ?></label>
                <input type="text"
                       name="ffm_stats[<?php echo esc_attr($index); ?>][label]"
                       value="<?php echo esc_attr($stat['label'] ?? ''); ?>"
                       class="ffm-stat-label-input"
                       placeholder="Années d'expérience">
            </div>

            <div class="ffm-stat-remove-wrap">
                <button type="button" class="button button-link-delete ffm-remove-stat">
                    <span class="dashicons dashicons-trash"></span>
                    <?php _e('Supprimer', 'fiche-formateur'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
