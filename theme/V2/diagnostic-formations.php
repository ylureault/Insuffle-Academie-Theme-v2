<?php
/**
 * DIAGNOSTIC PAGE FORMATIONS
 * Uploadez ce fichier à la racine de votre thème et visitez-le pour diagnostiquer le problème
 * URL: votresite.com/wp-content/themes/insuffle-academie/diagnostic-formations.php
 */

// Charger WordPress
require_once('../../../wp-load.php');

// Header
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Diagnostic Formations - Insuffle Académie</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .section {
            background: white;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #8E2183;
            margin-bottom: 10px;
        }
        h2 {
            color: #8E2183;
            border-bottom: 2px solid #FFD466;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .ok {
            color: #4CAF50;
            font-weight: bold;
        }
        .warning {
            color: #FF9800;
            font-weight: bold;
        }
        .error {
            color: #f44336;
            font-weight: bold;
        }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin: 20px 0;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #8E2183;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .badge-ok {
            background: #4CAF50;
            color: white;
        }
        .badge-warning {
            background: #FF9800;
            color: white;
        }
        .badge-error {
            background: #f44336;
            color: white;
        }
        code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        .solution {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="section">
        <h1>🔍 Diagnostic Page Formations</h1>
        <p>Insuffle Académie - <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>

    <?php
    // 1. VÉRIFICATION DE LA PAGE FORMATIONS
    echo '<div class="section">';
    echo '<h2>1️⃣ Page "Formations" dans WordPress</h2>';
    
    $formations_page = get_page_by_path('formations');
    
    if ($formations_page) {
        echo '<p class="ok">✅ La page "Formations" existe !</p>';
        echo '<table>';
        echo '<tr><th>Information</th><th>Valeur</th></tr>';
        echo '<tr><td>ID</td><td>' . $formations_page->ID . '</td></tr>';
        echo '<tr><td>Titre</td><td>' . $formations_page->post_title . '</td></tr>';
        echo '<tr><td>Slug</td><td><code>' . $formations_page->post_name . '</code></td></tr>';
        echo '<tr><td>URL</td><td><a href="' . get_permalink($formations_page->ID) . '" target="_blank">' . get_permalink($formations_page->ID) . '</a></td></tr>';
        echo '<tr><td>Statut</td><td>' . ($formations_page->post_status == 'publish' ? '<span class="badge badge-ok">Publié</span>' : '<span class="badge badge-warning">' . $formations_page->post_status . '</span>') . '</td></tr>';
        echo '<tr><td>Template</td><td><code>' . get_page_template_slug($formations_page->ID) . '</code></td></tr>';
        echo '<tr><td>Contenu</td><td>' . (empty($formations_page->post_content) ? '<span class="warning">⚠️ Vide</span>' : '<span class="ok">✅ A du contenu</span>') . '</td></tr>';
        echo '</table>';
        
        if (empty($formations_page->post_content)) {
            echo '<div class="solution">';
            echo '<strong>💡 Solution :</strong> La page existe mais est vide. Vous devez assigner un template ou ajouter du contenu.';
            echo '</div>';
        }
    } else {
        echo '<p class="error">❌ La page "Formations" n\'existe PAS dans WordPress !</p>';
        echo '<div class="solution">';
        echo '<strong>💡 Solution :</strong> Créez une page "Formations" dans WordPress :<br>';
        echo '1. Pages > Ajouter<br>';
        echo '2. Titre : "Formations"<br>';
        echo '3. Slug : "formations"<br>';
        echo '4. Publier';
        echo '</div>';
    }
    echo '</div>';
    
    // 2. VÉRIFICATION DES TEMPLATES
    echo '<div class="section">';
    echo '<h2>2️⃣ Templates disponibles</h2>';
    
    $theme_dir = get_template_directory();
    $templates_to_check = [
        'page-formations.php' => 'Template spécifique pour /formations/',
        'archive-formations.php' => 'Archive automatique pour /formations/',
        'template-formation.php' => 'Template pour les pages de formation individuelles'
    ];
    
    echo '<table>';
    echo '<tr><th>Fichier</th><th>Statut</th><th>Description</th></tr>';
    foreach ($templates_to_check as $file => $description) {
        $exists = file_exists($theme_dir . '/' . $file);
        echo '<tr>';
        echo '<td><code>' . $file . '</code></td>';
        echo '<td>' . ($exists ? '<span class="badge badge-ok">✅ Existe</span>' : '<span class="badge badge-error">❌ Manquant</span>') . '</td>';
        echo '<td>' . $description . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    $missing_templates = [];
    foreach ($templates_to_check as $file => $description) {
        if (!file_exists($theme_dir . '/' . $file)) {
            $missing_templates[] = $file;
        }
    }
    
    if (!empty($missing_templates)) {
        echo '<div class="solution">';
        echo '<strong>💡 Solution :</strong> Téléchargez et installez ces templates :<br>';
        foreach ($missing_templates as $file) {
            echo '- <code>' . $file . '</code><br>';
        }
        echo '</div>';
    }
    echo '</div>';
    
    // 3. VÉRIFICATION DES FORMATIONS (pages enfants)
    echo '<div class="section">';
    echo '<h2>3️⃣ Formations (pages enfants)</h2>';
    
    $formations = insuffle_get_formations();
    
    if (!empty($formations)) {
        echo '<p class="ok">✅ ' . count($formations) . ' formation(s) trouvée(s)</p>';
        echo '<table>';
        echo '<tr><th>Titre</th><th>Slug</th><th>Statut</th><th>Image</th><th>URL</th></tr>';
        foreach ($formations as $formation) {
            echo '<tr>';
            echo '<td>' . $formation->post_title . '</td>';
            echo '<td><code>' . $formation->post_name . '</code></td>';
            echo '<td>' . ($formation->post_status == 'publish' ? '<span class="badge badge-ok">Publié</span>' : '<span class="badge badge-warning">' . $formation->post_status . '</span>') . '</td>';
            echo '<td>' . (has_post_thumbnail($formation->ID) ? '<span class="ok">✅</span>' : '<span class="warning">⚠️</span>') . '</td>';
            echo '<td><a href="' . get_permalink($formation->ID) . '" target="_blank">Voir</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="error">❌ Aucune formation trouvée !</p>';
        echo '<div class="solution">';
        echo '<strong>💡 Solution :</strong> Créez des pages de formation :<br>';
        echo '1. Pages > Ajouter<br>';
        echo '2. Titre : "Nom de la formation"<br>';
        echo '3. <strong>Parent : Formations</strong> (très important !)<br>';
        echo '4. Template : "Page Formation"<br>';
        echo '5. Publier';
        echo '</div>';
    }
    echo '</div>';
    
    // 4. VÉRIFICATION DE LA FONCTION insuffle_get_formations
    echo '<div class="section">';
    echo '<h2>4️⃣ Fonction insuffle_get_formations()</h2>';
    
    if (function_exists('insuffle_get_formations')) {
        echo '<p class="ok">✅ La fonction existe</p>';
        
        // Test de la fonction
        $test_formations = insuffle_get_formations();
        echo '<p>Résultat du test : ' . count($test_formations) . ' formation(s) retournée(s)</p>';
    } else {
        echo '<p class="error">❌ La fonction n\'existe pas !</p>';
        echo '<div class="solution">';
        echo '<strong>💡 Solution :</strong> Vérifiez que <code>functions.php</code> contient la fonction <code>insuffle_get_formations()</code>';
        echo '</div>';
    }
    echo '</div>';
    
    // 5. STRUCTURE DES PAGES
    echo '<div class="section">';
    echo '<h2>5️⃣ Structure hiérarchique des pages</h2>';
    
    $all_pages = get_pages([
        'sort_column' => 'post_parent,menu_order,post_title'
    ]);
    
    echo '<table>';
    echo '<tr><th>Titre</th><th>ID</th><th>Parent</th><th>Statut</th></tr>';
    foreach ($all_pages as $page) {
        $parent_title = $page->post_parent ? get_the_title($page->post_parent) : '-';
        $indent = $page->post_parent ? '&nbsp;&nbsp;&nbsp;↳ ' : '';
        echo '<tr>';
        echo '<td>' . $indent . $page->post_title . '</td>';
        echo '<td>' . $page->ID . '</td>';
        echo '<td>' . $parent_title . '</td>';
        echo '<td>' . ($page->post_status == 'publish' ? '<span class="badge badge-ok">Publié</span>' : '<span class="badge badge-warning">' . $page->post_status . '</span>') . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
    
    // 6. URLS ET PERMALIENS
    echo '<div class="section">';
    echo '<h2>6️⃣ Configuration des permaliens</h2>';
    
    $permalink_structure = get_option('permalink_structure');
    echo '<table>';
    echo '<tr><th>Paramètre</th><th>Valeur</th></tr>';
    echo '<tr><td>Structure</td><td><code>' . ($permalink_structure ? $permalink_structure : 'Par défaut (non recommandé)') . '</code></td></tr>';
    echo '<tr><td>URL de base</td><td><code>' . home_url() . '</code></td></tr>';
    echo '<tr><td>URL /formations/</td><td><a href="' . home_url('/formations/') . '" target="_blank">' . home_url('/formations/') . '</a></td></tr>';
    echo '</table>';
    
    if (empty($permalink_structure)) {
        echo '<div class="solution">';
        echo '<strong>⚠️ Attention :</strong> Vous utilisez les permaliens par défaut. Il est recommandé d\'utiliser une structure personnalisée.<br>';
        echo 'Allez dans Réglages > Permaliens et choisissez "Nom de l\'article"';
        echo '</div>';
    }
    echo '</div>';
    
    // 7. RECOMMANDATIONS
    echo '<div class="section">';
    echo '<h2>7️⃣ Recommandations</h2>';
    
    $issues = [];
    
    if (!$formations_page) {
        $issues[] = '❌ Créer la page "Formations"';
    }
    
    if (!file_exists($theme_dir . '/page-formations.php') && !file_exists($theme_dir . '/archive-formations.php')) {
        $issues[] = '❌ Installer au moins un template (page-formations.php ou archive-formations.php)';
    }
    
    if (empty($formations)) {
        $issues[] = '⚠️ Créer des pages de formation (pages enfants de "Formations")';
    }
    
    if ($formations_page && empty($formations_page->post_content) && empty(get_page_template_slug($formations_page->ID))) {
        $issues[] = '⚠️ Assigner un template à la page "Formations" ou ajouter du contenu';
    }
    
    if (empty($issues)) {
        echo '<p class="ok" style="font-size: 1.2rem;">✅ Tout semble correct ! Si la page est toujours vide, videz le cache.</p>';
    } else {
        echo '<p class="error">Actions à effectuer :</p>';
        echo '<ul>';
        foreach ($issues as $issue) {
            echo '<li>' . $issue . '</li>';
        }
        echo '</ul>';
    }
    
    echo '</div>';
    
    // 8. PROCHAINES ÉTAPES
    echo '<div class="section">';
    echo '<h2>8️⃣ Prochaines étapes</h2>';
    echo '<div class="info">';
    echo '<strong>📋 Plan d\'action :</strong><br><br>';
    echo '<strong>1. Si la page "Formations" n\'existe pas :</strong><br>';
    echo '&nbsp;&nbsp;&nbsp;→ Créez-la dans WordPress (Pages > Ajouter)<br><br>';
    
    echo '<strong>2. Si elle existe mais est vide :</strong><br>';
    echo '&nbsp;&nbsp;&nbsp;→ Option A : Installez <code>page-formations.php</code> et assignez le template<br>';
    echo '&nbsp;&nbsp;&nbsp;→ Option B : Installez <code>archive-formations.php</code> (s\'active automatiquement)<br><br>';
    
    echo '<strong>3. Si aucune formation n\'apparaît :</strong><br>';
    echo '&nbsp;&nbsp;&nbsp;→ Créez des pages enfants sous "Formations"<br><br>';
    
    echo '<strong>4. Videz tous les caches :</strong><br>';
    echo '&nbsp;&nbsp;&nbsp;→ Cache WordPress, CDN, navigateur (Ctrl+F5)<br>';
    echo '</div>';
    echo '</div>';
    ?>
    
    <div class="section" style="text-align: center; background: #8E2183; color: white;">
        <h2 style="color: #FFD466; border: none;">✅ Diagnostic terminé</h2>
        <p>Utilisez ces informations pour corriger le problème de la page /formations/</p>
        <p style="margin-top: 20px; opacity: 0.9;">Insuffle Académie | <?php echo date('Y'); ?></p>
    </div>
</body>
</html>
