<?php
/**
 * SCRIPT DE RÉPARATION D'URGENCE
 * À exécuter UNE SEULE FOIS pour réparer le système
 *
 * INSTRUCTIONS:
 * 1. Uploadez ce fichier à la racine de votre site WordPress
 * 2. Accédez à : http://votresite.com/fix-urgent.php
 * 3. Supprimez ce fichier après l'exécution
 */

// Trouver wp-load.php automatiquement
$wp_load_found = false;
$possible_paths = array(
    __DIR__ . '/wp-load.php',                    // Racine du site
    __DIR__ . '/../wp-load.php',                 // Un niveau au-dessus
    __DIR__ . '/../../wp-load.php',              // Deux niveaux au-dessus
    __DIR__ . '/../../../wp-load.php',           // Trois niveaux au-dessus
    dirname(__DIR__) . '/wp-load.php',           // Parent du dossier actuel
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

echo '<html><head><meta charset="UTF-8"><title>Réparation Calendrier Formation</title>';
echo '<style>
    body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
    h1 { color: #667eea; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
    h2 { color: #764ba2; margin-top: 30px; background: white; padding: 10px; border-left: 5px solid #764ba2; }
    pre { background: #2d2d2d; color: #f8f8f2; padding: 20px; border-radius: 5px; overflow-x: auto; }
    .success { color: #4CAF50; font-weight: bold; }
    .error { color: #F44336; font-weight: bold; }
    .warning { color: #FF9800; font-weight: bold; }
    .info { background: #e7f3ff; border-left: 4px solid #2271b1; padding: 15px; margin: 15px 0; }
    .alert { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 15px 0; }
    .danger { background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 15px 0; }
    table { width: 100%; background: white; border-collapse: collapse; margin: 15px 0; }
    table th, table td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
    table th { background: #667eea; color: white; }
</style></head><body>';

echo '<h1>🔧 Réparation du système Calendrier Formation</h1>';
echo '<pre>';

// 1. Vérifier et créer la page d'inscription
echo "\n=== ÉTAPE 1: Vérification page d'inscription ===\n";

$settings = get_option('cf_settings', array());
$inscription_page_id = isset($settings['inscription_page_id']) ? intval($settings['inscription_page_id']) : 0;

echo "ID page dans settings: " . $inscription_page_id . "\n";

// Vérifier si la page existe
$page_exists = false;
if ($inscription_page_id > 0) {
    $page = get_post($inscription_page_id);
    if ($page && $page->post_status === 'publish') {
        echo "<span class='success'>✅ Page existe (ID: $inscription_page_id)</span>\n";
        echo "   Titre: " . $page->post_title . "\n";
        echo "   URL: " . get_permalink($inscription_page_id) . "\n";
        $page_exists = true;
    } else {
        echo "<span class='warning'>⚠️  Page ID $inscription_page_id n'existe pas ou n'est pas publiée</span>\n";
    }
}

// Si la page n'existe pas, la créer
if (!$page_exists) {
    echo "\n🔨 Création de la page d'inscription...\n";

    $inscription_page = array(
        'post_title'    => 'Inscription Formation',
        'post_content'  => '[formulaire_reservation]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
        'comment_status' => 'closed',
        'ping_status'   => 'closed'
    );

    $new_page_id = wp_insert_post($inscription_page);

    if ($new_page_id) {
        echo "<span class='success'>✅ Page créée avec succès (ID: $new_page_id)</span>\n";
        echo "   URL: " . get_permalink($new_page_id) . "\n";

        // Mettre à jour les settings
        $settings['inscription_page_id'] = $new_page_id;
        update_option('cf_settings', $settings);

        $inscription_page_id = $new_page_id;
        echo "<span class='success'>✅ Settings mis à jour</span>\n";
    } else {
        echo "<span class='error'>❌ Échec de création de la page</span>\n";
    }
}

// 2. Vérifier les settings
echo "\n=== ÉTAPE 2: Vérification des settings ===\n";
$settings = get_option('cf_settings', array());

echo "Settings actuels:\n";
foreach ($settings as $key => $value) {
    echo "  - $key: $value\n";
}

// S'assurer que form_url est vide (on utilise inscription_page_id maintenant)
if (!empty($settings['form_url'])) {
    echo "\n<span class='warning'>⚠️  form_url est défini, on le vide pour utiliser inscription_page_id</span>\n";
    $settings['form_url'] = '';
    update_option('cf_settings', $settings);
    echo "<span class='success'>✅ form_url vidé</span>\n";
}

// 3. Vérifier les tables de base de données
echo "\n=== ÉTAPE 3: Vérification des tables ===\n";

global $wpdb;
$tables = array(
    'cf_sessions' => $wpdb->prefix . 'cf_sessions',
    'cf_bookings' => $wpdb->prefix . 'cf_bookings',
    'cf_email_templates' => $wpdb->prefix . 'cf_email_templates'
);

foreach ($tables as $name => $table_name) {
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
    if ($table_exists) {
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        echo "<span class='success'>✅ Table $name existe ($count lignes)</span>\n";
    } else {
        echo "<span class='error'>❌ Table $name n'existe PAS</span>\n";
        echo "   → Vous devez désactiver puis réactiver le plugin\n";
    }
}

// 4. Vérifier les templates d'emails
echo "\n=== ÉTAPE 4: Vérification templates emails ===\n";

$table_email_templates = $wpdb->prefix . 'cf_email_templates';
$templates_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_email_templates");

if ($templates_count == 0) {
    echo "<span class='warning'>⚠️  Aucun template trouvé, insertion des templates par défaut...</span>\n";

    $default_templates = array(
        array(
            'template_key' => 'booking_confirmation_client',
            'template_name' => 'Confirmation de réservation - Client',
            'subject' => 'Confirmation de votre inscription à la formation {{formation_title}}',
            'body' => "Bonjour {{prenom}} {{nom}},\n\nNous confirmons votre demande d'inscription à la formation suivante :\n\n📚 Formation : {{formation_title}}\n🗓️ Session : {{session_title}}\n📅 Date de début : {{date_debut}}\n📅 Date de fin : {{date_fin}}\n⏱️ Durée : {{duree}}\n📍 Localisation : {{localisation}}\n\nDétails de votre réservation :\n- Nombre de participants : {{nombre_participants}}\n- Référence : {{booking_key}}\n\nNous reviendrons vers vous très prochainement pour confirmer votre inscription et vous transmettre les détails pratiques.\n\nCordialement,\nL'équipe formation",
            'variables' => 'prenom,nom,email,formation_title,session_title,date_debut,date_fin,duree,localisation,nombre_participants,booking_key'
        ),
        array(
            'template_key' => 'booking_notification_admin',
            'template_name' => 'Nouvelle réservation - Admin',
            'subject' => 'Nouvelle demande d\'inscription - {{formation_title}}',
            'body' => "Une nouvelle demande d'inscription a été reçue.\n\n=== FORMATION ===\nFormation : {{formation_title}}\nSession : {{session_title}}\nDates : du {{date_debut}} au {{date_fin}}\n\n=== PARTICIPANT ===\nNom : {{prenom}} {{nom}}\nEmail : {{email}}\nTéléphone : {{telephone}}\nFonction : {{fonction}}\n\n=== ENTREPRISE ===\nRaison sociale : {{raison_sociale}}\nSIRET : {{siret}}\nAdresse : {{adresse_complete}}\nSecteur : {{secteur_activite}}\n\n=== DÉTAILS ===\nNombre de participants : {{nombre_participants}}\nBesoins spécifiques : {{besoins_specifiques}}\nCommentaires : {{commentaires}}\n\nRéférence : {{booking_key}}\nDate de la demande : {{created_at}}\n\nAccéder à la réservation : {{admin_url}}",
            'variables' => 'prenom,nom,email,telephone,fonction,raison_sociale,siret,adresse_complete,secteur_activite,formation_title,session_title,date_debut,date_fin,duree,nombre_participants,besoins_specifiques,commentaires,booking_key,created_at,admin_url'
        ),
        array(
            'template_key' => 'booking_confirmed',
            'template_name' => 'Réservation confirmée - Client',
            'subject' => 'Votre inscription est confirmée - {{formation_title}}',
            'body' => "Bonjour {{prenom}} {{nom}},\n\nNous avons le plaisir de vous confirmer votre inscription à la formation :\n\n📚 Formation : {{formation_title}}\n🗓️ Session : {{session_title}}\n📅 Date de début : {{date_debut}}\n📅 Date de fin : {{date_fin}}\n📍 Localisation : {{localisation}}\n\nVous recevrez prochainement :\n✅ Les informations de connexion (si formation à distance)\n✅ Les modalités pratiques\n✅ Le programme détaillé\n✅ La convention de formation\n\nNombre de participants confirmés : {{nombre_participants}}\n\nÀ très bientôt !\n\nCordialement,\nL'équipe formation",
            'variables' => 'prenom,nom,email,formation_title,session_title,date_debut,date_fin,localisation,nombre_participants'
        )
    );

    foreach ($default_templates as $template) {
        $wpdb->insert($table_email_templates, $template);
    }

    echo "<span class='success'>✅ 3 templates d'emails créés</span>\n";
} else {
    echo "<span class='success'>✅ $templates_count template(s) d'emails trouvé(s)</span>\n";
}

// 5. Vérifier les sessions de test
echo "\n=== ÉTAPE 5: Vérification sessions ===\n";

$table_sessions = $wpdb->prefix . 'cf_sessions';
$sessions_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active'");
$sessions_future = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active' AND date_debut >= NOW()");

echo "Total sessions actives: $sessions_count\n";
echo "Sessions futures: $sessions_future\n";

if ($sessions_future == 0) {
    echo "<span class='warning'>⚠️  Aucune session future! Créez des sessions dans Agenda → Agenda</span>\n";
}

// 6. Tester la génération d'URL
echo "\n=== ÉTAPE 6: Test génération URL de réservation ===\n";

if ($inscription_page_id > 0) {
    $base_url = get_permalink($inscription_page_id);
    $test_url = add_query_arg(array(
        'session_id' => 1,
        'formation_id' => 51,
        'formation' => 'Test Formation',
        'session' => 'Session Test'
    ), $base_url);

    echo "URL de base: $base_url\n";
    echo "URL avec paramètres test: $test_url\n";

    if (strpos($test_url, 'session_id=1') !== false) {
        echo "<span class='success'>✅ Génération d'URL fonctionne</span>\n";
    } else {
        echo "<span class='error'>❌ Problème avec génération d'URL</span>\n";
    }
}

// 7. Vider les caches
echo "\n=== ÉTAPE 7: Nettoyage des caches ===\n";

// Permaliens
flush_rewrite_rules();
echo "<span class='success'>✅ Permaliens rafraîchis</span>\n";

// Cache WordPress
wp_cache_flush();
echo "<span class='success'>✅ Cache WordPress vidé</span>\n";

// 8. Récapitulatif final
echo "\n=== ✅ RÉCAPITULATIF ===\n";

$all_good = true;

// Vérification finale
$final_settings = get_option('cf_settings');
$final_page_id = isset($final_settings['inscription_page_id']) ? intval($final_settings['inscription_page_id']) : 0;

if ($final_page_id > 0 && get_post($final_page_id)) {
    echo "<span class='success'>✅ Page d'inscription configurée: " . get_permalink($final_page_id) . "</span>\n";
} else {
    echo "<span class='error'>❌ Page d'inscription NON configurée</span>\n";
    $all_good = false;
}

if ($templates_count >= 3) {
    echo "<span class='success'>✅ Templates d'emails OK</span>\n";
} else {
    echo "<span class='error'>❌ Templates d'emails manquants</span>\n";
    $all_good = false;
}

$tables_ok = true;
foreach ($tables as $name => $table_name) {
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
    if (!$table_exists) {
        $tables_ok = false;
        break;
    }
}

if ($tables_ok) {
    echo "<span class='success'>✅ Toutes les tables BDD existent</span>\n";
} else {
    echo "<span class='error'>❌ Tables BDD manquantes - DÉSACTIVEZ puis RÉACTIVEZ le plugin</span>\n";
    $all_good = false;
}

echo "\n";

if ($all_good) {
    echo "<span class='success'>🎉 TOUT EST OK ! Le système devrait fonctionner maintenant.</span>\n\n";
    echo "PROCHAINES ÉTAPES:\n";
    echo "1. Créez des sessions de formation dans Agenda → Agenda\n";
    echo "2. Ajoutez le shortcode [calendrier_formation] sur vos pages de formation\n";
    echo "3. Testez en cliquant sur 'Réserver ma place'\n";
    echo "4. Configurez vos emails dans Agenda → Templates emails\n";
    echo "5. SUPPRIMEZ ce fichier fix-urgent.php par sécurité\n";
} else {
    echo "<span class='error'>⚠️  ACTIONS REQUISES:</span>\n";
    if (!$tables_ok) {
        echo "1. Allez dans Plugins\n";
        echo "2. Désactivez 'Calendrier Formation'\n";
        echo "3. Réactivez 'Calendrier Formation'\n";
        echo "4. Relancez ce script\n";
    }
}

echo "\n</pre>";

echo '<div class="info">';
echo '<h2>📧 CONFIGURATION DES EMAILS</h2>';
echo '<p><strong>Pour que les emails fonctionnent, vous DEVEZ installer un plugin SMTP:</strong></p>';
echo '<ol>';
echo '<li>Allez dans <strong>Plugins → Ajouter</strong></li>';
echo '<li>Cherchez <strong>"WP Mail SMTP"</strong></li>';
echo '<li>Installez et activez</li>';
echo '<li>Configurez avec votre compte email (Gmail, Outlook, SendGrid, etc.)</li>';
echo '<li>Testez l\'envoi d\'email dans WP Mail SMTP → Email Test</li>';
echo '</ol>';
echo '<p><strong>Ensuite, configurez vos templates:</strong></p>';
echo '<ol>';
echo '<li>Allez dans <strong>Agenda → Templates emails</strong></li>';
echo '<li>Cliquez sur <strong>Éditer</strong> pour chaque template</li>';
echo '<li>Personnalisez le sujet et le corps</li>';
echo '<li>Cliquez sur <strong>Envoyer un test</strong> pour tester</li>';
echo '</ol>';
echo '</div>';

echo '<div class="alert">';
echo '<h2>🔗 LIENS UTILES</h2>';
echo '<ul>';
echo '<li><a href="' . admin_url('admin.php?page=calendrier-formation') . '" target="_blank">Agenda → Agenda</a> (créer sessions)</li>';
echo '<li><a href="' . admin_url('admin.php?page=cf-bookings') . '" target="_blank">Agenda → Réservations</a> (voir réservations)</li>';
echo '<li><a href="' . admin_url('admin.php?page=cf-email-templates') . '" target="_blank">Agenda → Templates emails</a> (configurer emails)</li>';
echo '<li><a href="' . admin_url('admin.php?page=cf-settings') . '" target="_blank">Agenda → Réglages</a> (paramètres)</li>';
echo '<li><a href="' . admin_url('plugin-install.php?s=WP%20Mail%20SMTP&tab=search&type=term') . '" target="_blank">Installer WP Mail SMTP</a></li>';
echo '</ul>';
echo '</div>';

echo '<div class="danger">';
echo '<h2>⚠️ SÉCURITÉ</h2>';
echo '<p style="font-size: 18px;"><strong>SUPPRIMEZ ce fichier fix-urgent.php MAINTENANT !</strong></p>';
echo '<p>Ce fichier contient du code sensible et ne doit pas rester sur votre serveur.</p>';
echo '</div>';

echo '</body></html>';
