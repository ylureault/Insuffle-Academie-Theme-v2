<?php
/**
 * Template: Liste des programmes de formation
 */

if (!defined('ABSPATH')) exit;

$total_formations = count($formations);
$with_programme = PFM_Formations_Scanner::count_with_programme();
?>

<div class="wrap pfm-admin-wrap">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-list-view"></span>
        <?php _e('Gérer les Programmes de Formation', 'programme-formation'); ?>
    </h1>

    <!-- Statistiques -->
    <div class="pfm-stats-cards">
        <div class="pfm-stat-card">
            <div class="pfm-stat-icon">📚</div>
            <div class="pfm-stat-content">
                <div class="pfm-stat-number"><?php echo esc_html($total_formations); ?></div>
                <div class="pfm-stat-label"><?php _e('Formations trouvées', 'programme-formation'); ?></div>
            </div>
        </div>

        <div class="pfm-stat-card pfm-stat-success">
            <div class="pfm-stat-icon">✅</div>
            <div class="pfm-stat-content">
                <div class="pfm-stat-number"><?php echo esc_html($with_programme); ?></div>
                <div class="pfm-stat-label"><?php _e('Avec programme', 'programme-formation'); ?></div>
            </div>
        </div>

        <div class="pfm-stat-card pfm-stat-warning">
            <div class="pfm-stat-icon">⚠️</div>
            <div class="pfm-stat-content">
                <div class="pfm-stat-number"><?php echo esc_html($total_formations - $with_programme); ?></div>
                <div class="pfm-stat-label"><?php _e('Sans programme', 'programme-formation'); ?></div>
            </div>
        </div>
    </div>

    <!-- Message d'info -->
    <?php if (empty($formations)): ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php _e('Aucune formation trouvée.', 'programme-formation'); ?></strong>
            </p>
            <p>
                <?php _e('Assurez-vous d\'avoir une page "Formations" avec des pages enfants.', 'programme-formation'); ?>
            </p>
        </div>
    <?php else: ?>
        <div class="notice notice-info">
            <p>
                <strong><?php _e('💡 Comment ça marche ?', 'programme-formation'); ?></strong>
            </p>
            <ol style="margin-left: 20px;">
                <li><?php _e('Cliquez sur "Éditer le programme" pour gérer les modules d\'une formation', 'programme-formation'); ?></li>
                <li><?php _e('Ajoutez les modules avec durée, objectif, contenu, etc.', 'programme-formation'); ?></li>
                <li><?php _e('Complétez les informations pratiques', 'programme-formation'); ?></li>
                <li><?php _e('Utilisez le shortcode', 'programme-formation'); ?> <code>[programme_formation]</code> <?php _e('dans la page de la formation', 'programme-formation'); ?></li>
            </ol>
        </div>
    <?php endif; ?>

    <!-- Liste des formations -->
    <?php if (!empty($formations)): ?>
        <div class="pfm-formations-table-wrap">
            <table class="wp-list-table widefat fixed striped pfm-formations-table">
                <thead>
                    <tr>
                        <th class="column-status"><?php _e('Statut', 'programme-formation'); ?></th>
                        <th class="column-title"><?php _e('Formation', 'programme-formation'); ?></th>
                        <th class="column-modules"><?php _e('Modules', 'programme-formation'); ?></th>
                        <th class="column-shortcode"><?php _e('Shortcode', 'programme-formation'); ?></th>
                        <th class="column-actions"><?php _e('Actions', 'programme-formation'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formations as $formation): ?>
                        <tr>
                            <!-- Statut -->
                            <td class="column-status">
                                <?php if ($formation->has_programme): ?>
                                    <span class="pfm-badge pfm-badge-success">
                                        <span class="dashicons dashicons-yes"></span>
                                        <?php _e('Configuré', 'programme-formation'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="pfm-badge pfm-badge-warning">
                                        <span class="dashicons dashicons-warning"></span>
                                        <?php _e('À configurer', 'programme-formation'); ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Titre -->
                            <td class="column-title">
                                <strong><?php echo esc_html($formation->post_title); ?></strong>
                                <div class="row-actions">
                                    <span class="view">
                                        <a href="<?php echo get_permalink($formation->ID); ?>" target="_blank">
                                            <?php _e('Voir la page', 'programme-formation'); ?>
                                        </a>
                                    </span>
                                </div>
                            </td>

                            <!-- Modules -->
                            <td class="column-modules">
                                <?php if ($formation->modules_count > 0): ?>
                                    <span class="pfm-modules-count">
                                        <?php echo esc_html($formation->modules_count); ?>
                                        <?php echo _n('module', 'modules', $formation->modules_count, 'programme-formation'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="pfm-no-modules"><?php _e('Aucun module', 'programme-formation'); ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- Shortcode -->
                            <td class="column-shortcode">
                                <code class="pfm-shortcode-display">[programme_formation]</code>
                                <button type="button" class="button button-small pfm-copy-shortcode" data-shortcode="[programme_formation]">
                                    <span class="dashicons dashicons-clipboard"></span>
                                    <?php _e('Copier', 'programme-formation'); ?>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="column-actions">
                                <a href="<?php echo admin_url('admin.php?page=pfm-edit-programme&formation_id=' . $formation->ID); ?>" class="button button-primary">
                                    <span class="dashicons dashicons-edit"></span>
                                    <?php _e('Éditer le programme', 'programme-formation'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
.pfm-admin-wrap {
    margin: 20px 20px 0 0;
}

.pfm-admin-wrap h1 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
}

.pfm-admin-wrap h1 .dashicons {
    font-size: 32px;
    width: 32px;
    height: 32px;
    color: #8E2183;
}

/* Stats Cards */
.pfm-stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.pfm-stat-card {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 20px;
    border-left: 4px solid #8E2183;
}

.pfm-stat-card.pfm-stat-success {
    border-left-color: #46b450;
}

.pfm-stat-card.pfm-stat-warning {
    border-left-color: #ffb900;
}

.pfm-stat-icon {
    font-size: 40px;
}

.pfm-stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #8E2183;
    line-height: 1;
}

.pfm-stat-success .pfm-stat-number {
    color: #46b450;
}

.pfm-stat-warning .pfm-stat-number {
    color: #ffb900;
}

.pfm-stat-label {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

/* Table */
.pfm-formations-table-wrap {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.pfm-formations-table {
    border: none;
}

.pfm-formations-table th {
    background: #8E2183;
    color: white;
    font-weight: 600;
    padding: 15px 10px;
}

.pfm-formations-table td {
    padding: 15px 10px;
    vertical-align: middle;
}

.column-status {
    width: 130px;
}

.column-modules {
    width: 100px;
    text-align: center;
}

.column-shortcode {
    width: 250px;
}

.column-actions {
    width: 200px;
    text-align: center;
}

/* Badges */
.pfm-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.pfm-badge-success {
    background: #e7f7e9;
    color: #46b450;
}

.pfm-badge-warning {
    background: #fff8e5;
    color: #ffb900;
}

.pfm-badge .dashicons {
    font-size: 16px;
    width: 16px;
    height: 16px;
}

/* Shortcode */
.pfm-shortcode-display {
    background: #f0f0f1;
    padding: 4px 8px;
    border-radius: 4px;
    font-family: monospace;
    font-size: 13px;
}

.pfm-copy-shortcode {
    margin-left: 10px;
}

.pfm-copy-shortcode .dashicons {
    font-size: 16px;
    width: 16px;
    height: 16px;
    margin-top: 2px;
}

/* Modules count */
.pfm-modules-count {
    display: inline-block;
    padding: 4px 12px;
    background: #e7f3ff;
    color: #0073aa;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.pfm-no-modules {
    color: #999;
    font-style: italic;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Copier le shortcode
    $('.pfm-copy-shortcode').on('click', function() {
        var shortcode = $(this).data('shortcode');
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val(shortcode).select();
        document.execCommand('copy');
        $temp.remove();

        var $btn = $(this);
        var originalText = $btn.html();
        $btn.html('<span class="dashicons dashicons-yes"></span> Copié !');
        $btn.css('background', '#46b450').css('color', 'white');

        setTimeout(function() {
            $btn.html(originalText);
            $btn.css('background', '').css('color', '');
        }, 2000);
    });
});
</script>
