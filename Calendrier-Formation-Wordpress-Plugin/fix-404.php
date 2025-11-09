<?php
/**
 * SCRIPT DE CORRECTION ERREUR 404
 * Spécifique pour corriger le problème de 404 avec paramètres URL
 *
 * INSTRUCTIONS:
 * 1. Uploadez ce fichier à la RACINE de votre site WordPress
 * 2. Accédez à : http://votresite.com/fix-404.php
 * 3. Supprimez ce fichier après l'exécution
 */

// Trouver wp-load.php automatiquement
$wp_load_found = false;
$possible_paths = array(
    __DIR__ . '/wp-load.php',
    __DIR__ . '/../wp-load.php',
    __DIR__ . '/../../wp-load.php',
    __DIR__ . '/../../../wp-load.php',
    dirname(__DIR__) . '/wp-load.php',
);

foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        require_once($path);
        $wp_load_found = true;
        break;
    }
}

if (!$wp_load_found) {
    die('❌ ERREUR: Impossible de trouver wp-load.php<br><br>
         SOLUTION: Uploadez ce fichier à la RACINE de votre site WordPress<br>
         (dans le même dossier que wp-config.php et wp-load.php)');
}

// Vérifier les droits admin
if (!current_user_can('manage_options')) {
    die('❌ Vous devez être administrateur pour exécuter ce script.<br><br>
         Connectez-vous d\'abord à WordPress, puis accédez à nouveau à ce script.');
}

echo '<html><head><meta charset="UTF-8"><title>Correction Erreur 404</title>';
echo '<style>
    body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
    h1 { color: #e74c3c; border-bottom: 3px solid #e74c3c; padding-bottom: 10px; }
    h2 { color: #764ba2; margin-top: 30px; background: white; padding: 10px; border-left: 5px solid #764ba2; }
    pre { background: #2d2d2d; color: #f8f8f2; padding: 20px; border-radius: 5px; overflow-x: auto; }
    .success { color: #4CAF50; font-weight: bold; }
    .error { color: #F44336; font-weight: bold; }
    .warning { color: #FF9800; font-weight: bold; }
    .info { background: #e7f3ff; border-left: 4px solid #2271b1; padding: 15px; margin: 15px 0; }
    .alert { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 15px 0; }
    .danger { background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 15px 0; }
    .code { background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
</style></head><body>';

echo '<h1>🔧 Correction Erreur 404 avec Paramètres URL</h1>';
echo '<pre>';

// ÉTAPE 1: Trouver la page d'inscription
echo "\n=== ÉTAPE 1: Recherche de la page Inscription Formation ===\n";

$pages = get_posts(array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    's' => 'Inscription Formation'
));

$inscription_page = null;
foreach ($pages as $page) {
    if (strpos($page->post_title, 'Inscription') !== false) {
        $inscription_page = $page;
        break;
    }
}

if ($inscription_page) {
    echo "<span class='success'>✅ Page trouvée: " . $inscription_page->post_title . " (ID: " . $inscription_page->ID . ")</span>\n";
    echo "   URL: " . get_permalink($inscription_page->ID) . "\n";
    echo "   Slug: " . $inscription_page->post_name . "\n";
    echo "   Status: " . $inscription_page->post_status . "\n";

    $existing_id = $inscription_page->ID;
} else {
    echo "<span class='warning'>⚠️  Aucune page trouvée</span>\n";
    $existing_id = null;
}

// ÉTAPE 2: Supprimer et recréer la page
echo "\n=== ÉTAPE 2: Recréation de la page ===\n";

if ($existing_id) {
    echo "Suppression de l'ancienne page...\n";
    wp_delete_post($existing_id, true); // true = forcer suppression définitive
    echo "<span class='success'>✅ Ancienne page supprimée</span>\n";
}

echo "\nCréation de la nouvelle page...\n";

$new_page_id = wp_insert_post(array(
    'post_title'    => 'Inscription Formation',
    'post_content'  => '[formulaire_reservation]',
    'post_status'   => 'publish',
    'post_type'     => 'page',
    'post_name'     => 'inscription-formation',
    'post_author'   => get_current_user_id(),
    'comment_status' => 'closed',
    'ping_status'   => 'closed',
    'page_template' => '' // Template par défaut
));

if ($new_page_id) {
    echo "<span class='success'>✅ Nouvelle page créée (ID: $new_page_id)</span>\n";
    echo "   URL: " . get_permalink($new_page_id) . "\n";

    // Mettre à jour les settings
    $settings = get_option('cf_settings', array());
    $settings['inscription_page_id'] = $new_page_id;
    update_option('cf_settings', $settings);
    echo "<span class='success'>✅ Settings mis à jour</span>\n";
} else {
    echo "<span class='error'>❌ Échec création page</span>\n";
    die();
}

// ÉTAPE 3: Forcer WordPress à accepter les query vars
echo "\n=== ÉTAPE 3: Configuration des query vars ===\n";

global $wp;

$custom_vars = array('session_id', 'formation_id', 'formation', 'session', 'date_debut', 'date_fin');
foreach ($custom_vars as $var) {
    if (!in_array($var, $wp->public_query_vars)) {
        $wp->add_query_var($var);
        echo "✅ Query var ajoutée: $var\n";
    }
}

// ÉTAPE 4: Forcer la régénération des permaliens
echo "\n=== ÉTAPE 4: Régénération des permaliens ===\n";

// Vider les règles de réécriture
delete_option('rewrite_rules');
echo "✅ Règles de réécriture vidées\n";

// Forcer la régénération
flush_rewrite_rules(true); // true = hard flush
echo "<span class='success'>✅ Permaliens régénérés (hard flush)</span>\n";

// Vider tous les caches
wp_cache_flush();
echo "✅ Cache WordPress vidé\n";

// ÉTAPE 5: Tester les URLs
echo "\n=== ÉTAPE 5: Test des URLs ===\n";

$base_url = get_permalink($new_page_id);
echo "URL de base: $base_url\n";

// Test 1: URL sans paramètres
echo "\n<span class='info'>Test 1: URL sans paramètres</span>\n";
echo $base_url . "\n";
$response1 = wp_remote_get($base_url);
if (!is_wp_error($response1)) {
    $code1 = wp_remote_retrieve_response_code($response1);
    if ($code1 == 200) {
        echo "<span class='success'>✅ Code HTTP: $code1 (OK)</span>\n";
    } else {
        echo "<span class='error'>❌ Code HTTP: $code1</span>\n";
    }
} else {
    echo "<span class='error'>❌ Erreur: " . $response1->get_error_message() . "</span>\n";
}

// Test 2: URL avec paramètres
echo "\n<span class='info'>Test 2: URL avec paramètres</span>\n";
$test_url = add_query_arg(array(
    'session_id' => 3,
    'formation_id' => 92,
    'formation' => 'TEST',
    'session' => 'TEST SESSION'
), $base_url);
echo $test_url . "\n";

$response2 = wp_remote_get($test_url);
if (!is_wp_error($response2)) {
    $code2 = wp_remote_retrieve_response_code($response2);
    if ($code2 == 200) {
        echo "<span class='success'>✅ Code HTTP: $code2 (OK)</span>\n";
    } else {
        echo "<span class='error'>❌ Code HTTP: $code2</span>\n";
    }
} else {
    echo "<span class='error'>❌ Erreur: " . $response2->get_error_message() . "</span>\n";
}

// ÉTAPE 6: Vérifier la configuration serveur
echo "\n=== ÉTAPE 6: Vérification configuration serveur ===\n";

// Vérifier mod_rewrite
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<span class='success'>✅ mod_rewrite activé</span>\n";
    } else {
        echo "<span class='error'>❌ mod_rewrite NON activé</span>\n";
    }
} else {
    echo "<span class='warning'>⚠️  Impossible de vérifier mod_rewrite</span>\n";
}

// Vérifier .htaccess
$htaccess_path = ABSPATH . '.htaccess';
if (file_exists($htaccess_path)) {
    echo "<span class='success'>✅ .htaccess existe</span>\n";

    $htaccess_content = file_get_contents($htaccess_path);
    if (strpos($htaccess_content, 'RewriteEngine On') !== false) {
        echo "✅ RewriteEngine activé dans .htaccess\n";
    } else {
        echo "<span class='error'>❌ RewriteEngine NON trouvé dans .htaccess</span>\n";
    }

    // Vérifier les droits
    if (is_writable($htaccess_path)) {
        echo "✅ .htaccess est modifiable\n";
    } else {
        echo "<span class='warning'>⚠️  .htaccess n'est PAS modifiable (droits)</span>\n";
    }
} else {
    echo "<span class='error'>❌ .htaccess n'existe PAS</span>\n";
}

echo "\n</pre>";

// ÉTAPE 7: Instructions finales
echo '<div class="alert">';
echo '<h2>🎯 ACTIONS IMMÉDIATES</h2>';
echo '<ol>';
echo '<li><strong>Testez cette URL dans votre navigateur:</strong><br>';
echo '<div class="code">' . esc_html($test_url) . '</div>';
echo 'Vous devez voir le formulaire (pas une erreur 404)</li>';
echo '<li><strong>Si vous avez toujours 404:</strong><br>';
echo 'Allez dans <strong>Réglages → Permaliens</strong> et cliquez sur <strong>Enregistrer</strong> (sans rien changer)</li>';
echo '<li><strong>Videz tous les caches:</strong>';
echo '<ul>';
echo '<li>Cache navigateur (Ctrl+Shift+Del)</li>';
echo '<li>Cache WordPress (si plugin de cache)</li>';
echo '<li>Cache hébergeur/Cloudflare</li>';
echo '</ul></li>';
echo '</ol>';
echo '</div>';

echo '<div class="info">';
echo '<h2>📧 SI LE PROBLÈME PERSISTE</h2>';
echo '<p><strong>Le problème vient probablement de votre configuration serveur.</strong></p>';
echo '<p><strong>Vérifiez avec votre hébergeur:</strong></p>';
echo '<ol>';
echo '<li><strong>mod_rewrite est-il activé ?</strong></li>';
echo '<li><strong>Les paramètres GET (?session_id=X) sont-ils autorisés ?</strong></li>';
echo '<li><strong>Y a-t-il des règles de sécurité qui bloquent les query strings ?</strong></li>';
echo '</ol>';
echo '<p><strong>Hébergeurs connus pour bloquer:</strong> Hostinger (parfois), OVH (règles strictes), 1&1 IONOS</p>';
echo '<p><strong>Solution:</strong> Demandez à votre hébergeur de désactiver les règles qui bloquent les query strings pour votre domaine.</p>';
echo '</div>';

echo '<div class="danger">';
echo '<h2>⚠️ SÉCURITÉ</h2>';
echo '<p style="font-size: 18px;"><strong>SUPPRIMEZ ce fichier fix-404.php MAINTENANT !</strong></p>';
echo '<p>Ce fichier contient du code sensible.</p>';
echo '</div>';

echo '<div class="info">';
echo '<h2>🔗 LIENS RAPIDES</h2>';
echo '<ul>';
echo '<li><a href="' . admin_url('options-permalink.php') . '" target="_blank">Réglages → Permaliens</a></li>';
echo '<li><a href="' . admin_url('edit.php?post_type=page') . '" target="_blank">Pages</a></li>';
echo '<li><a href="' . admin_url('admin.php?page=cf-settings') . '" target="_blank">Agenda → Paramètres</a></li>';
echo '<li><a href="' . get_permalink($new_page_id) . '" target="_blank">Voir la page Inscription</a></li>';
echo '<li><a href="' . $test_url . '" target="_blank">Tester URL avec paramètres</a></li>';
echo '</ul>';
echo '</div>';

echo '</body></html>';
