<?php
/**
 * Template Name: Réservation Encapsulée
 * Description: Template pour encapsuler les liens de réservation externes (Digiforma, etc.) dans une iframe
 */

// Récupérer l'URL de réservation depuis les paramètres
$reservation_url = isset($_GET['url']) ? esc_url_raw($_GET['url']) : '';
$session_id = isset($_GET['session']) ? intval($_GET['session']) : 0;

// Si aucune URL n'est fournie, rediriger vers l'accueil
if (empty($reservation_url)) {
    wp_redirect(home_url());
    exit;
}

// Récupérer les informations de la session si disponible
$session_title = '';
if ($session_id > 0) {
    global $wpdb;
    $table_sessions = $wpdb->prefix . 'cf_sessions';
    $session = $wpdb->get_row($wpdb->prepare(
        "SELECT s.*, p.post_title as formation_title
         FROM $table_sessions s
         LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
         WHERE s.id = %d",
        $session_id
    ));
    if ($session) {
        $session_title = $session->formation_title . ' - ' . $session->session_title;
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $session_title ? esc_html($session_title) . ' - ' : ''; ?>Réservation | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .reservation-header {
            background: linear-gradient(135deg, #8E2183 0%, #a02a94 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1000;
        }

        .reservation-header h1 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-3px);
        }

        .reservation-iframe-container {
            width: 100%;
            height: calc(100vh - 60px);
            position: relative;
            background: #f5f5f5;
        }

        .reservation-iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            z-index: 999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #8E2183;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: #8E2183;
            font-size: 16px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .reservation-header {
                flex-direction: column;
                gap: 10px;
                padding: 15px 20px;
            }

            .reservation-header h1 {
                font-size: 16px;
                text-align: center;
            }

            .reservation-iframe-container {
                height: calc(100vh - 100px);
            }
        }
    </style>
</head>
<body <?php body_class('reservation-page'); ?>>

<div class="reservation-header">
    <h1>
        <?php if ($session_title): ?>
            <?php echo esc_html($session_title); ?>
        <?php else: ?>
            Inscription à la formation
        <?php endif; ?>
    </h1>
    <a href="javascript:history.back()" class="back-button">
        <span>←</span>
        <span>Retour</span>
    </a>
</div>

<div class="reservation-iframe-container">
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Chargement du formulaire d'inscription...</div>
    </div>
    <iframe
        src="<?php echo esc_url($reservation_url); ?>"
        class="reservation-iframe"
        id="reservation-iframe"
        title="Formulaire d'inscription"
        loading="eager"
        allow="geolocation; microphone; camera"
    ></iframe>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iframe = document.getElementById('reservation-iframe');
    const loadingOverlay = document.getElementById('loading-overlay');

    // Cacher le loading après le chargement de l'iframe
    iframe.addEventListener('load', function() {
        setTimeout(function() {
            loadingOverlay.style.opacity = '0';
            loadingOverlay.style.transition = 'opacity 0.3s ease';
            setTimeout(function() {
                loadingOverlay.style.display = 'none';
            }, 300);
        }, 500);
    });

    // Timeout de sécurité pour cacher le loading après 10 secondes
    setTimeout(function() {
        if (loadingOverlay.style.display !== 'none') {
            loadingOverlay.style.display = 'none';
        }
    }, 10000);
});
</script>

<?php wp_footer(); ?>
</body>
</html>
