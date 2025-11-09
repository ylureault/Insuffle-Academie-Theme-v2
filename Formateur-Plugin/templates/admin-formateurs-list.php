<?php
/**
 * Template: Liste des formateurs
 */

if (!defined('ABSPATH')) exit;

$total_formateurs = count($formateurs);
$with_fiche = FFM_Formateurs_Scanner::count_with_fiche();
?>

<div class="wrap ffm-admin-wrap">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-groups"></span>
        <?php _e('Gérer les Fiches Formateurs', 'fiche-formateur'); ?>
    </h1>

    <!-- Statistiques -->
    <div class="ffm-stats-cards">
        <div class="ffm-stat-card">
            <div class="ffm-stat-icon">👨‍🏫</div>
            <div class="ffm-stat-content">
                <div class="ffm-stat-number"><?php echo esc_html($total_formateurs); ?></div>
                <div class="ffm-stat-label"><?php _e('Formateurs trouvés', 'fiche-formateur'); ?></div>
            </div>
        </div>

        <div class="ffm-stat-card ffm-stat-success">
            <div class="ffm-stat-icon">✅</div>
            <div class="ffm-stat-content">
                <div class="ffm-stat-number"><?php echo esc_html($with_fiche); ?></div>
                <div class="ffm-stat-label"><?php _e('Avec fiche', 'fiche-formateur'); ?></div>
            </div>
        </div>

        <div class="ffm-stat-card ffm-stat-warning">
            <div class="ffm-stat-icon">⚠️</div>
            <div class="ffm-stat-content">
                <div class="ffm-stat-number"><?php echo esc_html($total_formateurs - $with_fiche); ?></div>
                <div class="ffm-stat-label"><?php _e('Sans fiche', 'fiche-formateur'); ?></div>
            </div>
        </div>
    </div>

    <!-- Message d'info -->
    <?php if (empty($formateurs)): ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php _e('Aucun formateur trouvé.', 'fiche-formateur'); ?></strong>
            </p>
            <p>
                <?php _e('Assurez-vous d\'avoir une page "Formateurs" avec des pages enfants.', 'fiche-formateur'); ?>
            </p>
        </div>
    <?php else: ?>
        <div class="notice notice-info">
            <p>
                <strong><?php _e('💡 Comment ça marche ?', 'fiche-formateur'); ?></strong>
            </p>
            <ol style="margin-left: 20px;">
                <li><?php _e('Cliquez sur "Éditer la fiche" pour gérer les informations d\'un formateur', 'fiche-formateur'); ?></li>
                <li><?php _e('Ajoutez la photo, badge, nom, tagline, description', 'fiche-formateur'); ?></li>
                <li><?php _e('Ajoutez les stats (chiffres clés) et la citation', 'fiche-formateur'); ?></li>
                <li><?php _e('Utilisez le shortcode', 'fiche-formateur'); ?> <code>[fiche_formateur]</code> <?php _e('dans la page du formateur', 'fiche-formateur'); ?></li>
            </ol>
        </div>
    <?php endif; ?>

    <!-- Liste des formateurs -->
    <?php if (!empty($formateurs)): ?>
        <div class="ffm-formateurs-table-wrap">
            <table class="wp-list-table widefat fixed striped ffm-formateurs-table">
                <thead>
                    <tr>
                        <th class="column-status"><?php _e('Statut', 'fiche-formateur'); ?></th>
                        <th class="column-title"><?php _e('Formateur', 'fiche-formateur'); ?></th>
                        <th class="column-stats"><?php _e('Stats', 'fiche-formateur'); ?></th>
                        <th class="column-shortcode"><?php _e('Shortcode', 'fiche-formateur'); ?></th>
                        <th class="column-actions"><?php _e('Actions', 'fiche-formateur'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formateurs as $formateur): ?>
                        <tr>
                            <!-- Statut -->
                            <td class="column-status">
                                <?php if ($formateur->has_fiche): ?>
                                    <span class="ffm-badge ffm-badge-success">
                                        <span class="dashicons dashicons-yes"></span>
                                        <?php _e('Configurée', 'fiche-formateur'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="ffm-badge ffm-badge-warning">
                                        <span class="dashicons dashicons-warning"></span>
                                        <?php _e('À configurer', 'fiche-formateur'); ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Titre -->
                            <td class="column-title">
                                <strong><?php echo esc_html($formateur->post_title); ?></strong>
                                <div class="row-actions">
                                    <span class="view">
                                        <a href="<?php echo get_permalink($formateur->ID); ?>" target="_blank">
                                            <?php _e('Voir la page', 'fiche-formateur'); ?>
                                        </a>
                                    </span>
                                </div>
                            </td>

                            <!-- Stats -->
                            <td class="column-stats">
                                <?php if ($formateur->stats_count > 0): ?>
                                    <span class="ffm-stats-count">
                                        <?php echo esc_html($formateur->stats_count); ?>
                                        <?php echo _n('stat', 'stats', $formateur->stats_count, 'fiche-formateur'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="ffm-no-stats"><?php _e('Aucune stat', 'fiche-formateur'); ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- Shortcode -->
                            <td class="column-shortcode">
                                <code class="ffm-shortcode-display">[fiche_formateur]</code>
                                <button type="button" class="button button-small ffm-copy-shortcode" data-shortcode="[fiche_formateur]">
                                    <span class="dashicons dashicons-clipboard"></span>
                                    <?php _e('Copier', 'fiche-formateur'); ?>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="column-actions">
                                <a href="<?php echo admin_url('admin.php?page=ffm-edit-fiche&formateur_id=' . $formateur->ID); ?>" class="button button-primary">
                                    <span class="dashicons dashicons-edit"></span>
                                    <?php _e('Éditer la fiche', 'fiche-formateur'); ?>
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
.ffm-admin-wrap {
    margin: 20px 20px 0 0;
}

.ffm-admin-wrap h1 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
}

.ffm-admin-wrap h1 .dashicons {
    font-size: 32px;
    width: 32px;
    height: 32px;
    color: #8E2183;
}

/* Stats Cards */
.ffm-stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ffm-stat-card {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 20px;
    border-left: 4px solid #8E2183;
}

.ffm-stat-card.ffm-stat-success {
    border-left-color: #46b450;
}

.ffm-stat-card.ffm-stat-warning {
    border-left-color: #ffb900;
}

.ffm-stat-icon {
    font-size: 40px;
}

.ffm-stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #8E2183;
    line-height: 1;
}

.ffm-stat-success .ffm-stat-number {
    color: #46b450;
}

.ffm-stat-warning .ffm-stat-number {
    color: #ffb900;
}

.ffm-stat-label {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

/* Table */
.ffm-formateurs-table-wrap {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.ffm-formateurs-table {
    border: none;
}

.ffm-formateurs-table th {
    background: #8E2183;
    color: white;
    font-weight: 600;
    padding: 15px 10px;
}

.ffm-formateurs-table td {
    padding: 15px 10px;
    vertical-align: middle;
}

.column-status {
    width: 130px;
}

.column-stats {
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
.ffm-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.ffm-badge-success {
    background: #e7f7e9;
    color: #46b450;
}

.ffm-badge-warning {
    background: #fff8e5;
    color: #ffb900;
}

.ffm-badge .dashicons {
    font-size: 16px;
    width: 16px;
    height: 16px;
}

/* Shortcode */
.ffm-shortcode-display {
    background: #f0f0f1;
    padding: 4px 8px;
    border-radius: 4px;
    font-family: monospace;
    font-size: 13px;
}

.ffm-copy-shortcode {
    margin-left: 10px;
}

.ffm-copy-shortcode .dashicons {
    font-size: 16px;
    width: 16px;
    height: 16px;
    margin-top: 2px;
}

/* Stats count */
.ffm-stats-count {
    display: inline-block;
    padding: 4px 12px;
    background: #e7f3ff;
    color: #0073aa;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.ffm-no-stats {
    color: #999;
    font-style: italic;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Copier le shortcode
    $('.ffm-copy-shortcode').on('click', function() {
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
