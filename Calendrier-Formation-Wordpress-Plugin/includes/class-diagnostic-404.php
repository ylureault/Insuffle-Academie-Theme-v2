<?php
/**
 * Diagnostic et correction des erreurs 404
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Diagnostic_404 {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_post_cf_run_diagnostic', array($this, 'run_diagnostic'));
        add_action('admin_post_cf_fix_404', array($this, 'fix_404'));
    }

    /**
     * Page de diagnostic
     */
    public function render_diagnostic_page() {
        global $wpdb;

        ?>
        <div class="wrap">
            <h1>🔧 Diagnostic Erreur 404</h1>

            <?php
            // Si on a exécuté une action
            if (isset($_GET['action']) && $_GET['action'] === 'fixed') {
                echo '<div class="notice notice-success"><p><strong>✅ Corrections appliquées avec succès !</strong></p></div>';
            }
            ?>

            <div class="card" style="max-width: 100%;">
                <h2>🎯 Problème détecté</h2>
                <p><strong>URL sans paramètres :</strong> ✅ Fonctionne</p>
                <p><code>https://www.insuffle-academie.com/inscription-formation</code></p>

                <p><strong>URL avec paramètres :</strong> ❌ Erreur 404</p>
                <p><code>https://www.insuffle-academie.com/inscription-formation?session_id=3</code></p>

                <p><strong>Cause :</strong> Votre hébergeur bloque les paramètres URL (query strings) avant que WordPress ne les traite.</p>
            </div>

            <div class="card" style="max-width: 100%;">
                <h2>📊 État actuel du système</h2>

                <?php
                // Vérifier la page d'inscription
                $settings = get_option('cf_settings', array());
                $inscription_page_id = isset($settings['inscription_page_id']) ? intval($settings['inscription_page_id']) : 0;

                echo '<h3>Page Inscription Formation</h3>';
                if ($inscription_page_id && get_post($inscription_page_id)) {
                    $page = get_post($inscription_page_id);
                    echo '<p>✅ <strong>Page existe</strong></p>';
                    echo '<ul>';
                    echo '<li><strong>ID :</strong> ' . $page->ID . '</li>';
                    echo '<li><strong>Titre :</strong> ' . esc_html($page->post_title) . '</li>';
                    echo '<li><strong>Slug :</strong> ' . esc_html($page->post_name) . '</li>';
                    echo '<li><strong>Status :</strong> ' . esc_html($page->post_status) . '</li>';
                    echo '<li><strong>URL :</strong> <a href="' . get_permalink($page->ID) . '" target="_blank">' . get_permalink($page->ID) . '</a></li>';
                    echo '</ul>';
                } else {
                    echo '<p>❌ <strong>Page n\'existe pas ou ID invalide</strong></p>';
                }

                // Vérifier les sessions
                $table_sessions = $wpdb->prefix . 'cf_sessions';
                $sessions_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active'");
                $sessions_future = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active' AND date_debut >= NOW()");

                echo '<h3>Sessions</h3>';
                echo '<ul>';
                echo '<li><strong>Sessions actives :</strong> ' . $sessions_count . '</li>';
                echo '<li><strong>Sessions futures :</strong> ' . $sessions_future . '</li>';
                echo '</ul>';

                // Vérifier mod_rewrite (si possible)
                echo '<h3>Configuration serveur</h3>';
                echo '<ul>';

                if (function_exists('apache_get_modules')) {
                    $modules = apache_get_modules();
                    if (in_array('mod_rewrite', $modules)) {
                        echo '<li>✅ <strong>mod_rewrite :</strong> Activé</li>';
                    } else {
                        echo '<li>❌ <strong>mod_rewrite :</strong> Non activé</li>';
                    }
                } else {
                    echo '<li>⚠️ <strong>mod_rewrite :</strong> Impossible de vérifier</li>';
                }

                // Vérifier .htaccess
                $htaccess_path = ABSPATH . '.htaccess';
                if (file_exists($htaccess_path)) {
                    echo '<li>✅ <strong>.htaccess :</strong> Existe</li>';
                    if (is_writable($htaccess_path)) {
                        echo '<li>✅ <strong>Droits .htaccess :</strong> Modifiable</li>';
                    } else {
                        echo '<li>⚠️ <strong>Droits .htaccess :</strong> Non modifiable</li>';
                    }
                } else {
                    echo '<li>❌ <strong>.htaccess :</strong> N\'existe pas</li>';
                }

                echo '</ul>';
                ?>
            </div>

            <div class="card" style="max-width: 100%;">
                <h2>🔧 Actions de correction</h2>

                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                    <?php wp_nonce_field('cf_fix_404'); ?>
                    <input type="hidden" name="action" value="cf_fix_404">

                    <h3>Correction automatique (Tentative 1)</h3>
                    <p>Cette action va :</p>
                    <ul>
                        <li>Supprimer et recréer la page "Inscription Formation"</li>
                        <li>Forcer WordPress à accepter les paramètres URL</li>
                        <li>Régénérer les permaliens (hard flush)</li>
                        <li>Vider tous les caches</li>
                    </ul>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-hero">
                            ⚡ Appliquer les corrections automatiques
                        </button>
                    </p>
                </form>
            </div>

            <div class="card" style="max-width: 100%; background: #fff3cd; border-left: 4px solid #ffc107;">
                <h2>⚠️ Si les corrections automatiques ne fonctionnent pas</h2>

                <h3>Option A: Contacter votre hébergeur (RECOMMANDÉ)</h3>
                <p>Envoyez ce message à votre support technique :</p>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace;">
                    Bonjour,<br><br>

                    Mon site WordPress a besoin d'accepter les paramètres GET dans les URLs.<br><br>

                    Actuellement, cette URL fonctionne :<br>
                    https://www.insuffle-academie.com/inscription-formation<br><br>

                    Mais cette URL renvoie 404 :<br>
                    https://www.insuffle-academie.com/inscription-formation?session_id=3<br><br>

                    Pouvez-vous désactiver les règles ModSecurity ou autres qui bloquent les query strings pour mon domaine ?<br><br>

                    Merci
                </div>

                <h3 style="margin-top: 30px;">Option B: Solution alternative (segments d'URL)</h3>
                <p>Si votre hébergeur ne peut pas débloquer les paramètres, nous pouvons utiliser des segments d'URL :</p>
                <ul>
                    <li><strong>Au lieu de :</strong> <code>/inscription-formation?session_id=3</code></li>
                    <li><strong>On utilisera :</strong> <code>/inscription-formation/session/3/formation/92</code></li>
                </ul>
                <p>✅ Avantages : Fonctionne sur tous les hébergeurs, URLs plus propres</p>
                <p>📧 Contactez-nous si vous voulez cette solution</p>
            </div>

            <div class="card" style="max-width: 100%;">
                <h2>🧪 Tests à effectuer</h2>

                <?php
                if ($inscription_page_id && get_post($inscription_page_id)) {
                    $base_url = get_permalink($inscription_page_id);
                    $test_url = add_query_arg(array(
                        'session_id' => 3,
                        'formation_id' => 92,
                        'test' => 'ok'
                    ), $base_url);
                    ?>

                    <h3>Test 1 : URL sans paramètres</h3>
                    <p><a href="<?php echo esc_url($base_url); ?>" target="_blank" class="button">
                        📋 Tester : <?php echo esc_html($base_url); ?>
                    </a></p>
                    <p>✅ Devrait afficher le catalogue de sessions</p>

                    <h3>Test 2 : URL avec paramètres</h3>
                    <p><a href="<?php echo esc_url($test_url); ?>" target="_blank" class="button">
                        📋 Tester : <?php echo esc_html($test_url); ?>
                    </a></p>
                    <p>❓ Si vous voyez le formulaire → ✅ Tout fonctionne !</p>
                    <p>❌ Si vous voyez 404 → Contactez votre hébergeur (Option A ci-dessus)</p>

                <?php } else { ?>
                    <p>❌ Impossible de générer les URLs de test (page d'inscription manquante)</p>
                    <p>👉 Cliquez sur "Appliquer les corrections automatiques" ci-dessus</p>
                <?php } ?>
            </div>

            <div class="card" style="max-width: 100%;">
                <h2>📚 Documentation</h2>
                <ul>
                    <li><a href="https://github.com/ylureault/Calendrier-Formation-Wordpress-Plugin/blob/main/SOLUTION-404-ALTERNATIVE.md" target="_blank">📖 Guide complet : SOLUTION-404-ALTERNATIVE.md</a></li>
                    <li><a href="https://github.com/ylureault/Calendrier-Formation-Wordpress-Plugin/blob/main/VERIFICATIONS-COMPLETES.md" target="_blank">✅ Guide de vérifications complètes</a></li>
                    <li><a href="https://github.com/ylureault/Calendrier-Formation-Wordpress-Plugin/blob/main/DEPANNAGE-BOUTON-RESERVER.md" target="_blank">🔧 Guide de dépannage bouton Réserver</a></li>
                </ul>
            </div>

        </div>

        <style>
        .card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin-top: 0;
            color: #764ba2;
            border-bottom: 2px solid #764ba2;
            padding-bottom: 10px;
        }
        .card h3 {
            color: #2c3e50;
            margin-top: 25px;
        }
        .card ul {
            line-height: 1.8;
        }
        .card code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        </style>
        <?php
    }

    /**
     * Applique les corrections automatiques
     */
    public function fix_404() {
        check_admin_referer('cf_fix_404');

        if (!current_user_can('manage_options')) {
            wp_die('Permissions insuffisantes');
        }

        global $wp;

        // 1. Supprimer et recréer la page d'inscription
        $settings = get_option('cf_settings', array());
        $old_page_id = isset($settings['inscription_page_id']) ? intval($settings['inscription_page_id']) : 0;

        if ($old_page_id && get_post($old_page_id)) {
            wp_delete_post($old_page_id, true);
        }

        $new_page_id = wp_insert_post(array(
            'post_title'    => 'Inscription Formation',
            'post_content'  => '[formulaire_reservation]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'inscription-formation',
            'post_author'   => get_current_user_id(),
            'comment_status' => 'closed',
            'ping_status'   => 'closed',
        ));

        if ($new_page_id) {
            $settings['inscription_page_id'] = $new_page_id;
            update_option('cf_settings', $settings);
        }

        // 2. Ajouter les query vars
        $custom_vars = array('session_id', 'formation_id', 'formation', 'session', 'date_debut', 'date_fin');
        foreach ($custom_vars as $var) {
            if (!in_array($var, $wp->public_query_vars)) {
                $wp->add_query_var($var);
            }
        }

        // 3. Régénérer les permaliens (hard flush)
        delete_option('rewrite_rules');
        flush_rewrite_rules(true);

        // 4. Vider les caches
        wp_cache_flush();

        // Rediriger vers la page de diagnostic avec message de succès
        wp_redirect(admin_url('admin.php?page=cf-diagnostic-404&action=fixed'));
        exit;
    }
}
