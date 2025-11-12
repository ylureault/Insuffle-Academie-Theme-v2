<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget Formation Insufflé Académie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: transparent;
            padding: 20px;
        }

        .wfm-widget-container {
            background: linear-gradient(135deg, rgba(142,33,131,0.95) 0%, rgba(165,42,154,0.95) 100%);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }

        .wfm-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .wfm-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .wfm-logo {
            height: 60px;
            width: auto;
            object-fit: contain;
        }

        .wfm-logo.qualiopi {
            height: 80px;
        }

        .wfm-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
        }

        .wfm-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
            margin-top: 8px;
            font-weight: 400;
        }

        .wfm-formations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .wfm-formation-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: block;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .wfm-formation-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .wfm-formation-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .wfm-formation-title {
            color: #8E2183;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .wfm-formation-excerpt {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .wfm-formation-cta {
            color: #8E2183;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .wfm-formation-cta::after {
            content: '→';
            transition: transform 0.3s ease;
        }

        .wfm-formation-card:hover .wfm-formation-cta::after {
            transform: translateX(5px);
        }

        .wfm-no-formations {
            text-align: center;
            padding: 40px 20px;
            color: white;
        }

        .wfm-powered {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
        }

        @media (max-width: 640px) {
            body {
                padding: 10px;
            }

            .wfm-widget-container {
                padding: 20px;
            }

            .wfm-title {
                font-size: 1.4rem;
            }

            .wfm-formations-grid {
                grid-template-columns: 1fr;
            }

            .wfm-logo {
                height: 50px;
            }

            .wfm-logo.qualiopi {
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Récupérer le widget
    $widget_post = get_post($widget_id);

    if (!$widget_post || $widget_post->post_type !== 'widget_formation' || $widget_post->post_status !== 'publish') {
        echo '<p style="text-align:center;color:#666;">Widget non trouvé ou non publié.</p>';
        return;
    }

    // Récupérer les données du widget
    $formations_ids = get_post_meta($widget_id, '_wfm_formations', true);
    $show_logo_ia = get_post_meta($widget_id, '_wfm_show_logo_ia', true);
    $show_logo_qualiopi = get_post_meta($widget_id, '_wfm_show_logo_qualiopi', true);

    if (empty($formations_ids)) {
        $formations_ids = array();
    }
    ?>

    <div class="wfm-widget-container">
        <div class="wfm-header">
            <?php if ($show_logo_ia === '1' || $show_logo_qualiopi === '1'): ?>
                <div class="wfm-logos">
                    <?php if ($show_logo_ia === '1'): ?>
                        <?php
                        $logo_ia_url = wp_get_attachment_url(get_theme_mod('custom_logo'));
                        if (!$logo_ia_url) {
                            $logo_ia_url = 'https://www.insuffle-academie.com/wp-content/uploads/2024/01/logo-insuffle-academie.png';
                        }
                        ?>
                        <img src="<?php echo esc_url($logo_ia_url); ?>" alt="Insufflé Académie" class="wfm-logo">
                    <?php endif; ?>

                    <?php if ($show_logo_qualiopi === '1'): ?>
                        <img src="https://www.insuffle-academie.com/logo-qualiopi.png" alt="Qualiopi" class="wfm-logo qualiopi">
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <h2 class="wfm-title"><?php echo esc_html($widget_post->post_title); ?></h2>
            <p class="wfm-subtitle">Formations certifiées Qualiopi</p>
        </div>

        <?php if (!empty($formations_ids)): ?>
            <div class="wfm-formations-grid">
                <?php foreach ($formations_ids as $formation_id): ?>
                    <?php
                    $formation = get_post($formation_id);
                    if (!$formation || $formation->post_status !== 'publish') {
                        continue;
                    }

                    // Récupérer l'excerpt ou créer un extrait
                    $excerpt = $formation->post_excerpt;
                    if (empty($excerpt)) {
                        $excerpt = wp_trim_words(strip_tags($formation->post_content), 20);
                    }

                    // URL de la formation
                    $formation_url = get_permalink($formation_id);
                    ?>

                    <a href="<?php echo esc_url($formation_url); ?>" target="_blank" class="wfm-formation-card">
                        <span class="wfm-formation-icon">🎓</span>
                        <h3 class="wfm-formation-title"><?php echo esc_html($formation->post_title); ?></h3>
                        <?php if (!empty($excerpt)): ?>
                            <p class="wfm-formation-excerpt"><?php echo esc_html($excerpt); ?></p>
                        <?php endif; ?>
                        <span class="wfm-formation-cta">En savoir plus</span>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="wfm-powered">
                Propulsé par <strong>Insufflé Académie</strong>
            </div>
        <?php else: ?>
            <div class="wfm-no-formations">
                <p>Aucune formation configurée pour ce widget.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-resize de l'iframe (pour le parent)
        (function() {
            function sendHeight() {
                var height = document.body.scrollHeight;
                window.parent.postMessage({
                    type: 'insuffle-widget-resize',
                    height: height
                }, '*');
            }

            // Envoyer la hauteur au chargement
            if (window.addEventListener) {
                window.addEventListener('load', sendHeight);
            }

            // Observer les changements de taille
            var observer = new MutationObserver(sendHeight);
            observer.observe(document.body, {
                attributes: true,
                childList: true,
                subtree: true
            });
        })();
    </script>
</body>
</html>
