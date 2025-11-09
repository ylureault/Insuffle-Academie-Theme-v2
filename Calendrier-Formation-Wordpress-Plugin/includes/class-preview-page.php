<?php
/**
 * Page d'aperçu pour tester les shortcodes
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Preview_Page {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Constructor vide, le menu sera ajouté par CF_Agenda_Menu
    }

    /**
     * Affiche la page d'aperçu
     */
    public function render_preview_page() {
        global $wpdb;

        // Récupérer les formations disponibles
        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        $formations = get_pages(array(
            'child_of' => $parent_id,
            'post_type' => 'page',
            'post_status' => 'publish'
        ));

        // Récupérer quelques sessions pour l'aperçu
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $sample_sessions = $wpdb->get_results("
            SELECT s.*, p.post_title as formation_title
            FROM $table_sessions s
            LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
            WHERE s.status = 'active'
            ORDER BY s.date_debut DESC
            LIMIT 3
        ");

        ?>
        <div class="wrap cf-preview-page">
            <h1 class="cf-preview-title">
                <span class="dashicons dashicons-visibility"></span>
                <?php _e('Aperçu des Shortcodes', 'calendrier-formation'); ?>
            </h1>

            <div class="cf-preview-container">

                <!-- Section: Testeur de shortcode -->
                <div class="cf-preview-section">
                    <h2><span class="dashicons dashicons-admin-tools"></span> <?php _e('Testeur de shortcode', 'calendrier-formation'); ?></h2>

                    <div class="cf-tester-box">
                        <p><?php _e('Entrez un shortcode pour le tester en temps réel :', 'calendrier-formation'); ?></p>

                        <form method="post" class="cf-shortcode-form">
                            <?php wp_nonce_field('cf_preview_shortcode', 'cf_preview_nonce'); ?>

                            <div class="cf-form-group">
                                <label for="shortcode_input">
                                    <strong><?php _e('Shortcode à tester :', 'calendrier-formation'); ?></strong>
                                </label>
                                <input
                                    type="text"
                                    id="shortcode_input"
                                    name="shortcode_input"
                                    class="cf-shortcode-input"
                                    value="<?php echo isset($_POST['shortcode_input']) ? esc_attr($_POST['shortcode_input']) : '[calendrier_formation]'; ?>"
                                    placeholder="[calendrier_formation]"
                                >
                            </div>

                            <?php if (!empty($formations)): ?>
                            <div class="cf-form-group">
                                <label for="formation_select">
                                    <strong><?php _e('Ou choisissez une formation :', 'calendrier-formation'); ?></strong>
                                </label>
                                <select id="formation_select" name="formation_select" class="cf-formation-select">
                                    <option value=""><?php _e('-- Sélectionner une formation --', 'calendrier-formation'); ?></option>
                                    <?php foreach ($formations as $formation): ?>
                                        <option value="<?php echo esc_attr($formation->ID); ?>">
                                            <?php echo esc_html($formation->post_title); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endif; ?>

                            <div class="cf-form-actions">
                                <button type="submit" class="button button-primary">
                                    <span class="dashicons dashicons-yes-alt"></span>
                                    <?php _e('Tester le shortcode', 'calendrier-formation'); ?>
                                </button>
                            </div>
                        </form>

                        <?php
                        // Afficher le résultat du shortcode
                        if (isset($_POST['shortcode_input']) && wp_verify_nonce($_POST['cf_preview_nonce'], 'cf_preview_shortcode')) {
                            $shortcode = sanitize_text_field($_POST['shortcode_input']);
                            ?>
                            <div class="cf-preview-result">
                                <h3><?php _e('Résultat :', 'calendrier-formation'); ?></h3>
                                <div class="cf-preview-output">
                                    <?php echo do_shortcode($shortcode); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Section: Exemples rapides -->
                <div class="cf-preview-section">
                    <h2><span class="dashicons dashicons-format-gallery"></span> <?php _e('Exemples rapides', 'calendrier-formation'); ?></h2>

                    <div class="cf-quick-examples">
                        <div class="cf-quick-example">
                            <h3><?php _e('Affichage en cartes (par défaut)', 'calendrier-formation'); ?></h3>
                            <code>[calendrier_formation]</code>
                            <button class="button button-small cf-copy-btn" data-shortcode="[calendrier_formation]">
                                <?php _e('Copier', 'calendrier-formation'); ?>
                            </button>
                        </div>

                        <div class="cf-quick-example">
                            <h3><?php _e('Affichage en tableau', 'calendrier-formation'); ?></h3>
                            <code>[calendrier_formation display="table"]</code>
                            <button class="button button-small cf-copy-btn" data-shortcode='[calendrier_formation display="table"]'>
                                <?php _e('Copier', 'calendrier-formation'); ?>
                            </button>
                        </div>

                        <div class="cf-quick-example">
                            <h3><?php _e('Limiter à 3 sessions', 'calendrier-formation'); ?></h3>
                            <code>[calendrier_formation limit="3"]</code>
                            <button class="button button-small cf-copy-btn" data-shortcode='[calendrier_formation limit="3"]'>
                                <?php _e('Copier', 'calendrier-formation'); ?>
                            </button>
                        </div>

                        <div class="cf-quick-example">
                            <h3><?php _e('Formulaire de réservation', 'calendrier-formation'); ?></h3>
                            <code>[formulaire_reservation]</code>
                            <button class="button button-small cf-copy-btn" data-shortcode="[formulaire_reservation]">
                                <?php _e('Copier', 'calendrier-formation'); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section: Sessions actuelles -->
                <?php if (!empty($sample_sessions)): ?>
                <div class="cf-preview-section">
                    <h2><span class="dashicons dashicons-calendar-alt"></span> <?php _e('Sessions récentes dans la base', 'calendrier-formation'); ?></h2>

                    <div class="cf-sessions-list">
                        <?php foreach ($sample_sessions as $session): ?>
                            <div class="cf-session-preview-card">
                                <div class="cf-session-preview-header">
                                    <strong><?php echo esc_html($session->formation_title); ?></strong>
                                    <span class="cf-session-id">ID: <?php echo esc_html($session->id); ?></span>
                                </div>
                                <div class="cf-session-preview-body">
                                    <div class="cf-session-detail">
                                        <span class="dashicons dashicons-calendar"></span>
                                        <?php echo esc_html($session->session_title); ?>
                                    </div>
                                    <div class="cf-session-detail">
                                        <span class="dashicons dashicons-clock"></span>
                                        <?php
                                        $date_debut = new DateTime($session->date_debut);
                                        $date_fin = new DateTime($session->date_fin);
                                        echo esc_html($date_debut->format('d/m/Y') . ' - ' . $date_fin->format('d/m/Y'));
                                        ?>
                                    </div>
                                    <div class="cf-session-detail">
                                        <span class="dashicons dashicons-groups"></span>
                                        <?php echo esc_html($session->places_disponibles . ' / ' . $session->places_total); ?> places
                                    </div>
                                </div>
                                <div class="cf-session-preview-footer">
                                    <code>post_id="<?php echo esc_attr($session->post_id); ?>"</code>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="cf-preview-section cf-preview-notice">
                    <div class="notice notice-info inline">
                        <p>
                            <strong><?php _e('Aucune session trouvée', 'calendrier-formation'); ?></strong><br>
                            <?php _e('Créez des sessions depuis "Agenda > Sessions" ou "Agenda > Calendrier" pour les voir apparaître ici.', 'calendrier-formation'); ?>
                        </p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Section: Informations système -->
                <div class="cf-preview-section">
                    <h2><span class="dashicons dashicons-info"></span> <?php _e('Informations système', 'calendrier-formation'); ?></h2>

                    <table class="cf-info-table">
                        <tr>
                            <th><?php _e('Page parent Formations (ID)', 'calendrier-formation'); ?></th>
                            <td>
                                <?php echo esc_html($parent_id); ?>
                                <?php if (get_post($parent_id)): ?>
                                    - <a href="<?php echo esc_url(get_permalink($parent_id)); ?>" target="_blank">
                                        <?php echo esc_html(get_the_title($parent_id)); ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php _e('Nombre de formations', 'calendrier-formation'); ?></th>
                            <td><?php echo count($formations); ?></td>
                        </tr>
                        <tr>
                            <th><?php _e('Total sessions actives', 'calendrier-formation'); ?></th>
                            <td>
                                <?php
                                $total_sessions = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active'");
                                echo esc_html($total_sessions);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php _e('Sessions à venir', 'calendrier-formation'); ?></th>
                            <td>
                                <?php
                                $upcoming_sessions = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active' AND date_debut >= NOW()");
                                echo esc_html($upcoming_sessions);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php _e('Page d\'inscription (ID)', 'calendrier-formation'); ?></th>
                            <td>
                                <?php
                                $inscription_page_id = isset($settings['inscription_page_id']) ? $settings['inscription_page_id'] : 0;
                                echo esc_html($inscription_page_id);
                                if ($inscription_page_id && get_post($inscription_page_id)) {
                                    echo ' - <a href="' . esc_url(get_permalink($inscription_page_id)) . '" target="_blank">' . esc_html(get_the_title($inscription_page_id)) . '</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        <style>
            .cf-preview-page {
                background: #f9f9f9;
            }

            .cf-preview-title {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 20px 0;
                border-bottom: 2px solid #0073aa;
                margin-bottom: 30px;
            }

            .cf-preview-title .dashicons {
                font-size: 32px;
                width: 32px;
                height: 32px;
                color: #0073aa;
            }

            .cf-preview-container {
                max-width: 1200px;
            }

            .cf-preview-section {
                background: white;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 25px;
                margin-bottom: 25px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .cf-preview-section h2 {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 0;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid #f0f0f0;
                font-size: 22px;
                color: #333;
            }

            .cf-preview-section h2 .dashicons {
                color: #0073aa;
                font-size: 26px;
                width: 26px;
                height: 26px;
            }

            .cf-tester-box {
                background: #f7f7f7;
                border-left: 4px solid #0073aa;
                padding: 20px;
                border-radius: 4px;
            }

            .cf-form-group {
                margin-bottom: 20px;
            }

            .cf-form-group label {
                display: block;
                margin-bottom: 8px;
                color: #333;
            }

            .cf-shortcode-input,
            .cf-formation-select {
                width: 100%;
                max-width: 600px;
                padding: 10px;
                font-size: 14px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-family: monospace;
            }

            .cf-form-actions {
                margin-top: 20px;
            }

            .cf-form-actions .button-primary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                font-size: 14px;
            }

            .cf-preview-result {
                margin-top: 30px;
                padding-top: 30px;
                border-top: 2px solid #ddd;
            }

            .cf-preview-result h3 {
                margin-bottom: 15px;
                color: #333;
            }

            .cf-preview-output {
                background: white;
                border: 2px dashed #0073aa;
                padding: 20px;
                border-radius: 4px;
                min-height: 100px;
            }

            .cf-quick-examples {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 15px;
            }

            .cf-quick-example {
                background: #f7f7f7;
                border: 1px solid #ddd;
                padding: 15px;
                border-radius: 4px;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .cf-quick-example h3 {
                margin: 0;
                font-size: 14px;
                color: #333;
            }

            .cf-quick-example code {
                background: #282c34;
                color: #abb2bf;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 13px;
                display: block;
                overflow-x: auto;
            }

            .cf-copy-btn {
                align-self: flex-start;
                margin-top: 5px;
            }

            .cf-sessions-list {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: 15px;
            }

            .cf-session-preview-card {
                background: #f7f7f7;
                border: 1px solid #ddd;
                border-radius: 4px;
                overflow: hidden;
            }

            .cf-session-preview-header {
                background: #0073aa;
                color: white;
                padding: 12px 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cf-session-id {
                font-size: 11px;
                opacity: 0.9;
            }

            .cf-session-preview-body {
                padding: 15px;
            }

            .cf-session-detail {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 8px;
                color: #333;
                font-size: 13px;
            }

            .cf-session-detail .dashicons {
                color: #0073aa;
                font-size: 18px;
                width: 18px;
                height: 18px;
            }

            .cf-session-preview-footer {
                padding: 10px 15px;
                background: #fff;
                border-top: 1px solid #ddd;
            }

            .cf-session-preview-footer code {
                font-size: 12px;
                background: #e7f3ff;
                color: #0073aa;
                padding: 4px 8px;
                border-radius: 3px;
            }

            .cf-info-table {
                width: 100%;
                border-collapse: collapse;
            }

            .cf-info-table th,
            .cf-info-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #e0e0e0;
            }

            .cf-info-table th {
                background: #f0f0f0;
                font-weight: 600;
                width: 40%;
                color: #333;
            }

            .cf-info-table td {
                color: #666;
            }

            .cf-preview-notice .notice {
                margin: 0;
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            // Mise à jour du shortcode quand on sélectionne une formation
            $('#formation_select').on('change', function() {
                var formationId = $(this).val();
                if (formationId) {
                    $('#shortcode_input').val('[calendrier_formation post_id="' + formationId + '"]');
                } else {
                    $('#shortcode_input').val('[calendrier_formation]');
                }
            });

            // Copier le shortcode
            $('.cf-copy-btn').on('click', function(e) {
                e.preventDefault();
                var shortcode = $(this).data('shortcode');
                var $temp = $('<input>');
                $('body').append($temp);
                $temp.val(shortcode).select();
                document.execCommand('copy');
                $temp.remove();

                var $btn = $(this);
                var originalText = $btn.text();
                $btn.text('<?php _e('Copié !', 'calendrier-formation'); ?>');
                setTimeout(function() {
                    $btn.text(originalText);
                }, 2000);
            });
        });
        </script>
        <?php
    }
}
