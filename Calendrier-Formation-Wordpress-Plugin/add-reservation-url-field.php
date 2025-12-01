<?php
/**
 * Script de migration manuelle
 * Ajoute le champ reservation_url à la table cf_sessions
 *
 * UTILISATION :
 * 1. Accédez à ce fichier via votre navigateur : votresite.com/wp-content/plugins/calendrier-formation/add-reservation-url-field.php
 * 2. Ou exécutez-le via WP-CLI : wp eval-file add-reservation-url-field.php
 *
 * SÉCURITÉ : Ce fichier sera automatiquement supprimé après utilisation
 */

// Charger WordPress
require_once('../../../wp-load.php');

// Vérifier que l'utilisateur est administrateur
if (!current_user_can('manage_options')) {
    wp_die('Accès refusé. Vous devez être administrateur pour exécuter ce script.');
}

global $wpdb;
$table_sessions = $wpdb->prefix . 'cf_sessions';

echo '<h1>Migration du champ reservation_url</h1>';
echo '<style>body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
      .success { color: green; background: #e7f5e7; padding: 10px; border-left: 4px solid green; margin: 10px 0; }
      .error { color: red; background: #ffe7e7; padding: 10px; border-left: 4px solid red; margin: 10px 0; }
      .info { color: blue; background: #e7f0ff; padding: 10px; border-left: 4px solid blue; margin: 10px 0; }
      pre { background: #f5f5f5; padding: 10px; border-radius: 4px; overflow-x: auto; }</style>';

// Vérifier si la table existe
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_sessions'") === $table_sessions;

if (!$table_exists) {
    echo '<div class="error">❌ La table ' . esc_html($table_sessions) . ' n\'existe pas.</div>';
    echo '<div class="info">💡 Activez d\'abord le plugin "Calendrier Formation" pour créer les tables.</div>';
    exit;
}

echo '<div class="info">✓ Table trouvée : ' . esc_html($table_sessions) . '</div>';

// Vérifier si la colonne existe déjà
$column_exists = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = %s
        AND TABLE_NAME = %s
        AND COLUMN_NAME = 'reservation_url'",
        DB_NAME,
        $table_sessions
    )
);

if (!empty($column_exists)) {
    echo '<div class="success">✅ Le champ "reservation_url" existe déjà dans la table.</div>';
    echo '<div class="info">Aucune action nécessaire. Vous pouvez fermer cette page.</div>';

    // Afficher la structure de la colonne
    $column_info = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT COLUMN_TYPE, COLUMN_DEFAULT, IS_NULLABLE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = %s
            AND TABLE_NAME = %s
            AND COLUMN_NAME = 'reservation_url'",
            DB_NAME,
            $table_sessions
        )
    );

    if ($column_info) {
        echo '<h3>Structure de la colonne :</h3>';
        echo '<pre>';
        echo 'Type: ' . esc_html($column_info->COLUMN_TYPE) . "\n";
        echo 'Défaut: ' . esc_html($column_info->COLUMN_DEFAULT ?? 'NULL') . "\n";
        echo 'Nullable: ' . esc_html($column_info->IS_NULLABLE);
        echo '</pre>';
    }

    exit;
}

echo '<div class="info">⚠️ Le champ "reservation_url" n\'existe pas encore. Ajout en cours...</div>';

// Ajouter la colonne
$sql = "ALTER TABLE $table_sessions ADD COLUMN reservation_url VARCHAR(500) DEFAULT '' AFTER status";

echo '<h3>Requête SQL :</h3>';
echo '<pre>' . esc_html($sql) . '</pre>';

$result = $wpdb->query($sql);

if ($result !== false) {
    echo '<div class="success">✅ Le champ "reservation_url" a été ajouté avec succès !</div>';

    // Vérifier que le champ a bien été ajouté
    $verify = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = %s
            AND TABLE_NAME = %s
            AND COLUMN_NAME = 'reservation_url'",
            DB_NAME,
            $table_sessions
        )
    );

    if (!empty($verify)) {
        echo '<div class="success">✓ Vérification réussie : le champ est maintenant présent dans la table.</div>';
    }

    echo '<h3>Prochaines étapes :</h3>';
    echo '<ol>';
    echo '<li>Vous pouvez maintenant éditer vos sessions et ajouter des liens de réservation personnalisés</li>';
    echo '<li>Rendez-vous dans : <strong>Calendrier Formation > Sessions</strong></li>';
    echo '<li>Modifiez une session et remplissez le champ "Lien de réservation personnalisé"</li>';
    echo '</ol>';

} else {
    echo '<div class="error">❌ Erreur lors de l\'ajout du champ.</div>';

    if ($wpdb->last_error) {
        echo '<div class="error">Erreur MySQL : ' . esc_html($wpdb->last_error) . '</div>';
    }

    echo '<h3>Solutions possibles :</h3>';
    echo '<ul>';
    echo '<li>Vérifiez que l\'utilisateur MySQL a les droits ALTER TABLE</li>';
    echo '<li>Vérifiez la connexion à la base de données</li>';
    echo '<li>Essayez d\'exécuter la requête SQL manuellement dans phpMyAdmin</li>';
    echo '</ul>';
}

echo '<hr>';
echo '<p><small>Script de migration - Calendrier Formation Plugin</small></p>';
