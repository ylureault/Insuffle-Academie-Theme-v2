<?php
/**
 * Template: Liste des galeries
 */

if (!defined('ABSPATH')) exit;

$total_formations = count($formations);
$with_galerie = GFM_Formations_Scanner::count_with_galerie();
?>

<div class="wrap gfm-admin-wrap">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-images-alt2"></span>
        <?php _e('Gérer les Galeries Formation', 'galerie-formation'); ?>
    </h1>

    <!-- Statistiques -->
    <div class="gfm-stats-cards">
        <div class="gfm-stat-card">
            <div class="gfm-stat-icon">📚</div>
            <div class="gfm-stat-content">
                <div class="gfm-stat-number"><?php echo esc_html($total_formations); ?></div>
                <div class="gfm-stat-label"><?php _e('Formations trouvées', 'galerie-formation'); ?></div>
            </div>
        </div>

        <div class="gfm-stat-card gfm-stat-success">
            <div class="gfm-stat-icon">✅</div>
            <div class="gfm-stat-content">
                <div class="gfm-stat-number"><?php echo esc_html($with_galerie); ?></div>
                <div class="gfm-stat-label"><?php _e('Avec galerie', 'galerie-formation'); ?></div>
            </div>
        </div>

        <div class="gfm-stat-card gfm-stat-warning">
            <div class="gfm-stat-icon">⚠️</div>
            <div class="gfm-stat-content">
                <div class="gfm-stat-number"><?php echo esc_html($total_formations - $with_galerie); ?></div>
                <div class="gfm-stat-label"><?php _e('Sans galerie', 'galerie-formation'); ?></div>
            </div>
        </div>
    </div>

    <!-- Message d'info -->
    <?php if (empty($formations)): ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php _e('Aucune formation trouvée.', 'galerie-formation'); ?></strong>
            </p>
            <p>
                <?php _e('Assurez-vous d\'avoir une page "Formations" avec des pages enfants.', 'galerie-formation'); ?>
            </p>
        </div>
    <?php else: ?>
        <div class="notice notice-info">
            <p>
                <strong><?php _e('💡 Comment ça marche ?', 'galerie-formation'); ?></strong>
            </p>
            <ol style="margin-left: 20px;">
                <li><?php _e('Cliquez sur "Éditer la galerie" pour gérer les images d\'une formation', 'galerie-formation'); ?></li>
                <li><?php _e('Ajoutez des images avec titre, description et catégorie', 'galerie-formation'); ?></li>
                <li><?php _e('Glissez-déposez pour réorganiser les images', 'galerie-formation'); ?></li>
                <li><?php _e('Utilisez le shortcode', 'galerie-formation'); ?> <code>[galerie_formation]</code> <?php _e('dans la page de la formation', 'galerie-formation'); ?></li>
            </ol>
        </div>
    <?php endif; ?>

    <!-- Liste des formations -->
    <?php if (!empty($formations)): ?>
        <div class="gfm-formations-table-wrap">
            <table class="wp-list-table widefat fixed striped gfm-formations-table">
                <thead>
                    <tr>
                        <th class="column-status"><?php _e('Statut', 'galerie-formation'); ?></th>
                        <th class="column-title"><?php _e('Formation', 'galerie-formation'); ?></th>
                        <th class="column-images"><?php _e('Images', 'galerie-formation'); ?></th>
                        <th class="column-shortcode"><?php _e('Shortcode', 'galerie-formation'); ?></th>
                        <th class="column-actions"><?php _e('Actions', 'galerie-formation'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formations as $formation): ?>
                        <tr>
                            <!-- Statut -->
                            <td class="column-status">
                                <?php if ($formation->has_galerie): ?>
                                    <span class="gfm-badge gfm-badge-success">
                                        <span class="dashicons dashicons-yes"></span>
                                        <?php _e('Configurée', 'galerie-formation'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="gfm-badge gfm-badge-warning">
                                        <span class="dashicons dashicons-warning"></span>
                                        <?php _e('À configurer', 'galerie-formation'); ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Titre -->
                            <td class="column-title">
                                <strong><?php echo esc_html($formation->post_title); ?></strong>
                                <div class="row-actions">
                                    <span class="view">
                                        <a href="<?php echo get_permalink($formation->ID); ?>" target="_blank">
                                            <?php _e('Voir la page', 'galerie-formation'); ?>
                                        </a>
                                    </span>
                                </div>
                            </td>

                            <!-- Images -->
                            <td class="column-images">
                                <?php if ($formation->images_count > 0): ?>
                                    <span class="gfm-images-count">
                                        <?php echo esc_html($formation->images_count); ?>
                                        <?php echo _n('image', 'images', $formation->images_count, 'galerie-formation'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="gfm-no-images"><?php _e('Aucune image', 'galerie-formation'); ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- Shortcode -->
                            <td class="column-shortcode">
                                <code class="gfm-shortcode-display">[galerie_formation]</code>
                                <button type="button" class="button button-small gfm-copy-shortcode" data-shortcode="[galerie_formation]">
                                    <span class="dashicons dashicons-clipboard"></span>
                                    <?php _e('Copier', 'galerie-formation'); ?>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="column-actions">
                                <a href="<?php echo admin_url('admin.php?page=gfm-edit-galerie&formation_id=' . $formation->ID); ?>" class="button button-primary">
                                    <span class="dashicons dashicons-edit"></span>
                                    <?php _e('Éditer la galerie', 'galerie-formation'); ?>
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
/* Reprendre les mêmes styles que les autres plugins */
.gfm-admin-wrap { margin: 20px 20px 0 0; }
.gfm-admin-wrap h1 { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
.gfm-admin-wrap h1 .dashicons { font-size: 32px; width: 32px; height: 32px; color: #8E2183; }
.gfm-stats-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
.gfm-stat-card { background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 20px; border-left: 4px solid #8E2183; }
.gfm-stat-card.gfm-stat-success { border-left-color: #46b450; }
.gfm-stat-card.gfm-stat-warning { border-left-color: #ffb900; }
.gfm-stat-icon { font-size: 40px; }
.gfm-stat-number { font-size: 32px; font-weight: 700; color: #8E2183; line-height: 1; }
.gfm-stat-success .gfm-stat-number { color: #46b450; }
.gfm-stat-warning .gfm-stat-number { color: #ffb900; }
.gfm-stat-label { font-size: 14px; color: #666; margin-top: 5px; }
.gfm-formations-table-wrap { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.gfm-formations-table { border: none; }
.gfm-formations-table th { background: #8E2183; color: white; font-weight: 600; padding: 15px 10px; }
.gfm-formations-table td { padding: 15px 10px; vertical-align: middle; }
.column-status { width: 130px; }
.column-images { width: 100px; text-align: center; }
.column-shortcode { width: 250px; }
.column-actions { width: 200px; text-align: center; }
.gfm-badge { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
.gfm-badge-success { background: #e7f7e9; color: #46b450; }
.gfm-badge-warning { background: #fff8e5; color: #ffb900; }
.gfm-badge .dashicons { font-size: 16px; width: 16px; height: 16px; }
.gfm-shortcode-display { background: #f0f0f1; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-size: 13px; }
.gfm-copy-shortcode { margin-left: 10px; }
.gfm-copy-shortcode .dashicons { font-size: 16px; width: 16px; height: 16px; margin-top: 2px; }
.gfm-images-count { display: inline-block; padding: 4px 12px; background: #e7f3ff; color: #0073aa; border-radius: 12px; font-size: 12px; font-weight: 600; }
.gfm-no-images { color: #999; font-style: italic; }
</style>

<script>
jQuery(document).ready(function($) {
    $('.gfm-copy-shortcode').on('click', function() {
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
