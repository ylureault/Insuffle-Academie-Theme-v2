<?php
/**
 * Script de vérification de la table wp_cf_bookings
 * À exécuter via URL: votresite.com/wp-content/plugins/calendrier-formation/check-table.php
 */

// Charger WordPress
require_once('../../../wp-load.php');

// Vérifier si c'est un admin
if (!current_user_can('manage_options')) {
    die('Accès refusé');
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vérification Table Réservations</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #0073aa; padding-bottom: 10px; }
        h2 { color: #0073aa; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background: #0073aa; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .success { color: #46b450; font-weight: bold; }
        .error { color: #dc3232; font-weight: bold; }
        .warning { color: #ffb900; font-weight: bold; }
        .info-box { background: #e5f5fa; border-left: 4px solid #0073aa; padding: 15px; margin: 20px 0; }
        .sql-box { background: #f0f0f0; padding: 15px; border-radius: 4px; font-family: monospace; white-space: pre-wrap; margin: 10px 0; }
        .button { background: #0073aa; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .button:hover { background: #005a87; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Vérification de la Table wp_cf_bookings</h1>

        <?php
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        // 1. Vérifier l'existence de la table
        echo '<h2>1. Existence de la table</h2>';
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_bookings'");

        if ($table_exists) {
            echo '<p class="success">✅ La table ' . $table_bookings . ' existe</p>';
        } else {
            echo '<p class="error">❌ La table ' . $table_bookings . ' n\'existe PAS !</p>';
            echo '<p>La table doit être créée. Activez/Réactivez le plugin pour la créer automatiquement.</p>';
            echo '</div></body></html>';
            exit;
        }

        // 2. Lister toutes les colonnes
        echo '<h2>2. Structure de la table</h2>';
        $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_bookings");

        if ($columns) {
            echo '<table>';
            echo '<tr><th>Colonne</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>';
            foreach ($columns as $column) {
                echo '<tr>';
                echo '<td><strong>' . esc_html($column->Field) . '</strong></td>';
                echo '<td>' . esc_html($column->Type) . '</td>';
                echo '<td>' . esc_html($column->Null) . '</td>';
                echo '<td>' . esc_html($column->Key) . '</td>';
                echo '<td>' . esc_html($column->Default) . '</td>';
                echo '<td>' . esc_html($column->Extra) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }

        // 3. Lister les colonnes que le code essaie d'insérer
        echo '<h2>3. Colonnes attendues par le code</h2>';
        $expected_columns = array(
            'id' => 'AUTO_INCREMENT PRIMARY KEY',
            'session_id' => 'ID de la session (obligatoire)',
            'civilite' => 'M./Mme/Autre',
            'nom' => 'Nom (obligatoire)',
            'prenom' => 'Prénom (obligatoire)',
            'email' => 'Email (obligatoire)',
            'telephone' => 'Téléphone',
            'fonction' => 'Fonction dans l\'entreprise',
            'raison_sociale' => 'Nom de l\'entreprise',
            'siret' => 'SIRET',
            'adresse' => 'Adresse complète',
            'code_postal' => 'Code postal',
            'ville' => 'Ville',
            'pays' => 'Pays (défaut: France)',
            'secteur_activite' => 'Secteur d\'activité',
            'taille_entreprise' => 'Taille de l\'entreprise',
            'nombre_participants' => 'Nombre de participants',
            'besoins_specifiques' => 'Besoins spécifiques',
            'commentaires' => 'Commentaires',
            'type_facturation' => 'Type de facturation',
            'status' => 'pending/confirmed/cancelled',
            'booking_key' => 'Clé unique',
            'ip_address' => 'IP du client',
            'user_agent' => 'User agent',
            'created_at' => 'Date de création (auto)'
        );

        // Récupérer les noms des colonnes réelles
        $actual_columns = array();
        foreach ($columns as $column) {
            $actual_columns[] = $column->Field;
        }

        echo '<table>';
        echo '<tr><th>Colonne</th><th>Description</th><th>Statut</th></tr>';
        foreach ($expected_columns as $col_name => $description) {
            $exists = in_array($col_name, $actual_columns);
            echo '<tr>';
            echo '<td><strong>' . esc_html($col_name) . '</strong></td>';
            echo '<td>' . esc_html($description) . '</td>';
            if ($exists) {
                echo '<td class="success">✅ Existe</td>';
            } else {
                echo '<td class="error">❌ Manquante</td>';
            }
            echo '</tr>';
        }
        echo '</table>';

        // 4. Colonnes supplémentaires (dans la BDD mais pas dans le code)
        echo '<h2>4. Colonnes supplémentaires (dans la BDD mais pas utilisées par le code)</h2>';
        $extra_columns = array_diff($actual_columns, array_keys($expected_columns));
        if (!empty($extra_columns)) {
            echo '<p class="warning">⚠️ Colonnes supplémentaires trouvées :</p>';
            echo '<ul>';
            foreach ($extra_columns as $extra_col) {
                echo '<li>' . esc_html($extra_col) . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="success">✅ Aucune colonne supplémentaire</p>';
        }

        // 5. Colonnes manquantes
        echo '<h2>5. Colonnes manquantes (attendues par le code mais absentes de la BDD)</h2>';
        $missing_columns = array_diff(array_keys($expected_columns), $actual_columns);
        if (!empty($missing_columns)) {
            echo '<p class="error">❌ Colonnes manquantes :</p>';
            echo '<ul>';
            foreach ($missing_columns as $missing_col) {
                echo '<li><strong>' . esc_html($missing_col) . '</strong> - ' . esc_html($expected_columns[$missing_col]) . '</li>';
            }
            echo '</ul>';

            echo '<div class="info-box">';
            echo '<h3>🔧 SOLUTION</h3>';
            echo '<p>Le plugin va maintenant adapter automatiquement les données qu\'il insère selon les colonnes disponibles.</p>';
            echo '<p>Aucune action manuelle requise !</p>';
            echo '</div>';
        } else {
            echo '<p class="success">✅ Toutes les colonnes sont présentes</p>';
        }

        // 6. Nombre de réservations
        echo '<h2>6. Statistiques</h2>';
        $total_bookings = $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings");
        echo '<p>Nombre total de réservations : <strong>' . intval($total_bookings) . '</strong></p>';

        if ($total_bookings > 0) {
            $bookings = $wpdb->get_results("SELECT * FROM $table_bookings ORDER BY created_at DESC LIMIT 5");
            echo '<h3>Dernières réservations (5 max)</h3>';
            echo '<table>';
            echo '<tr><th>ID</th><th>Session ID</th><th>Nom</th><th>Email</th><th>Status</th><th>Date</th></tr>';
            foreach ($bookings as $booking) {
                echo '<tr>';
                echo '<td>' . intval($booking->id) . '</td>';
                echo '<td>' . intval($booking->session_id) . '</td>';
                echo '<td>' . esc_html($booking->nom ?? '-') . ' ' . esc_html($booking->prenom ?? '-') . '</td>';
                echo '<td>' . esc_html($booking->email ?? '-') . '</td>';
                echo '<td>' . esc_html($booking->status ?? '-') . '</td>';
                echo '<td>' . esc_html($booking->created_at ?? '-') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }

        // 7. Test d'insertion
        echo '<h2>7. Test d\'insertion (simulation)</h2>';
        echo '<p>Simulation de l\'insertion d\'une réservation avec les colonnes disponibles...</p>';

        $test_data = array(
            'session_id' => 999,
            'civilite' => 'Test',
            'nom' => 'Test',
            'prenom' => 'Test',
            'email' => 'test@example.com',
        );

        // Filtrer pour ne garder que les colonnes existantes
        $filtered_data = array();
        foreach ($test_data as $key => $value) {
            if (in_array($key, $actual_columns)) {
                $filtered_data[$key] = $value;
            }
        }

        echo '<p class="success">✅ Données filtrées prêtes pour l\'insertion :</p>';
        echo '<div class="sql-box">' . print_r($filtered_data, true) . '</div>';

        ?>

        <h2>✅ Vérification terminée</h2>
        <div class="info-box">
            <p><strong>Prochaine étape :</strong></p>
            <p>Essayez de soumettre le formulaire de réservation. Si une erreur survient, le message d'erreur détaillé vous indiquera exactement ce qui ne va pas.</p>
            <p><a href="<?php echo admin_url('admin.php?page=calendrier-formation'); ?>" class="button">Retour à l'admin</a></p>
        </div>
    </div>
</body>
</html>
