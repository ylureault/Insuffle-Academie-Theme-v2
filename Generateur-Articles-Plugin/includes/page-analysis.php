<?php
/**
 * Page: Analyser mon style
 * Analyse du blog Insufflé et génération d'idées
 */

if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1>🎨 Analyser mon style d'écriture</h1>
    <p class="description">Analysez le blog Insufflé pour vous inspirer et générer de nouvelles idées d'articles personnalisées.</p>

    <!-- Workflow en 3 étapes -->
    <div class="gar-workflow">
        <div class="gar-workflow-step">
            <div class="gar-workflow-number">1</div>
            <div class="gar-workflow-content">
                <h3>📊 Analyser mes articles</h3>
                <p>D'abord, allez dans "Mes Articles" pour analyser vos articles existants</p>
            </div>
        </div>
        <div class="gar-workflow-arrow">→</div>
        <div class="gar-workflow-step">
            <div class="gar-workflow-number">2</div>
            <div class="gar-workflow-content">
                <h3>🔍 Scanner le blog Insufflé</h3>
                <p>Récupérez des exemples d'articles du blog pour inspiration</p>
            </div>
        </div>
        <div class="gar-workflow-arrow">→</div>
        <div class="gar-workflow-step">
            <div class="gar-workflow-number">3</div>
            <div class="gar-workflow-content">
                <h3>✨ Générer des idées</h3>
                <p>Créez automatiquement de nouvelles idées dans votre style</p>
            </div>
        </div>
    </div>

    <!-- Section 1: Scanner le blog Insufflé -->
    <div class="gar-idea-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; margin-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="color: white; margin: 0;">🌐 Scanner le blog Insufflé</h2>
                <p style="margin: 10px 0 0 0; opacity: 0.9;">Récupérez les titres d'articles et analysez le style d'écriture du blog https://www.insuffle.com/le-blog/</p>
            </div>
            <button type="button" id="gar-scan-blog" class="button button-hero" style="background: white; color: #f5576c; border: none; font-weight: 600;">
                🔍 Scanner le blog
            </button>
        </div>

        <div id="gar-blog-results" style="display: none; margin-top: 20px;">
            <div style="background: rgba(255, 255, 255, 0.15); padding: 20px; border-radius: 8px;">
                <h3 style="color: white; margin-top: 0;">📝 Résultats du scan</h3>
                <div id="gar-blog-content">
                    <!-- Rempli via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Générer de nouvelles idées -->
    <div class="gar-idea-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; margin-top: 20px;">
        <h2 style="color: white; margin-top: 0;">🚀 Générer de nouvelles idées d'articles</h2>
        <p style="margin: 10px 0 20px 0; opacity: 0.9;">Créez automatiquement de nouvelles idées d'articles basées sur l'analyse de votre style et du blog Insufflé.</p>

        <div style="background: rgba(255, 255, 255, 0.15); padding: 20px; border-radius: 8px;">
            <div style="display: flex; gap: 20px; align-items: end; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600; color: white;">
                        Nombre d'idées à générer :
                    </label>
                    <input type="number" id="gar-generate-count" value="10" min="1" max="50"
                           style="width: 100%; padding: 10px; border-radius: 4px; border: 2px solid rgba(255,255,255,0.3); font-size: 16px;">
                </div>
                <div>
                    <button type="button" id="gar-generate-ideas" class="button button-hero"
                            style="background: white; color: #11998e; border: none; font-weight: 600; padding: 10px 30px;">
                        ✨ Générer les idées
                    </button>
                </div>
            </div>

            <div id="gar-generate-info" style="margin-top: 15px; padding: 15px; background: rgba(255,255,255,0.2); border-radius: 6px; display: none;">
                <p style="margin: 0; font-size: 0.95em;">
                    💡 <strong>Astuce :</strong> Les nouvelles idées seront créées en fonction de vos thématiques favorites,
                    votre longueur d'article moyenne, et le style du blog Insufflé. Elles apparaîtront dans l'onglet "Idées d'Articles".
                </p>
            </div>
        </div>

        <div id="gar-generate-results" style="display: none; margin-top: 20px;">
            <div style="background: rgba(255, 255, 255, 0.15); padding: 20px; border-radius: 8px;">
                <div id="gar-generate-content">
                    <!-- Rempli via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Guide d'utilisation -->
    <div class="gar-idea-card" style="margin-top: 30px; background: #f9f9f9;">
        <h3>📖 Guide d'utilisation</h3>

        <h4>1️⃣ Analysez vos articles existants</h4>
        <p>Commencez par aller dans <strong>"Mes Articles"</strong> et cliquez sur "Analyser mes articles".
        Cela permettra au système de comprendre votre style d'écriture : longueur moyenne, thématiques favorites, ton, etc.</p>

        <h4>2️⃣ Scannez le blog Insufflé</h4>
        <p>Cliquez sur <strong>"Scanner le blog"</strong> ci-dessus pour récupérer des exemples de titres et analyser
        le style d'écriture du blog https://www.insuffle.com/le-blog/. Cela enrichit l'analyse avec des références externes.</p>

        <h4>3️⃣ Générez de nouvelles idées</h4>
        <p>Une fois l'analyse terminée, choisissez combien d'idées vous voulez générer (recommandé : 10-20) et cliquez sur
        <strong>"Générer les idées"</strong>. Les nouvelles idées apparaîtront dans l'onglet "Idées d'Articles" et pourront
        être validées pour créer des articles WordPress.</p>

        <h4>✨ Résultat</h4>
        <p>Vous obtiendrez des idées d'articles personnalisées qui correspondent à :</p>
        <ul>
            <li>Votre style d'écriture personnel (ton "je", structure, émojis)</li>
            <li>Vos thématiques favorites (facilitation, intelligence collective, management)</li>
            <li>Votre longueur d'article idéale (1500-3000 mots)</li>
            <li>Le style et les sujets du blog Insufflé</li>
        </ul>
    </div>
</div>

<style>
/* Workflow Steps */
.gar-workflow {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin: 30px 0;
    flex-wrap: wrap;
}

.gar-workflow-step {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    flex: 1;
    min-width: 200px;
    max-width: 300px;
    text-align: center;
    transition: all 0.3s ease;
}

.gar-workflow-step:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    transform: translateY(-5px);
}

.gar-workflow-number {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
    font-weight: bold;
    margin: 0 auto 15px;
}

.gar-workflow-content h3 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1.1em;
}

.gar-workflow-content p {
    margin: 0;
    color: #666;
    font-size: 0.9em;
    line-height: 1.5;
}

.gar-workflow-arrow {
    font-size: 2em;
    color: #667eea;
    font-weight: bold;
}

/* Results animations */
#gar-blog-results, #gar-generate-results {
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
    }
    to {
        opacity: 1;
        max-height: 2000px;
    }
}

#gar-blog-content h4, #gar-generate-content h4 {
    color: white;
    margin: 20px 0 10px 0;
    font-size: 1.1em;
}

#gar-blog-content h4:first-child, #gar-generate-content h4:first-child {
    margin-top: 0;
}

#gar-blog-content ul, #gar-generate-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

#gar-blog-content ul li, #gar-generate-content ul li {
    background: rgba(255, 255, 255, 0.1);
    padding: 10px 15px;
    margin-bottom: 8px;
    border-radius: 6px;
    border-left: 4px solid rgba(255, 255, 255, 0.3);
}

.gar-blog-title {
    font-weight: 600;
    color: white;
}

.gar-success-message {
    background: rgba(255, 255, 255, 0.2);
    padding: 20px;
    border-radius: 8px;
    text-align: center;
}

.gar-success-message h3 {
    color: white;
    margin: 0 0 10px 0;
    font-size: 1.5em;
}

.gar-success-message p {
    margin: 0;
    opacity: 0.9;
}

/* Responsive */
@media (max-width: 768px) {
    .gar-workflow {
        flex-direction: column;
    }

    .gar-workflow-arrow {
        transform: rotate(90deg);
    }

    .gar-workflow-step {
        max-width: 100%;
    }
}
</style>

<script>
jQuery(document).ready(function($) {

    // Scanner le blog Insufflé
    $('#gar-scan-blog').on('click', function() {
        var $btn = $(this);
        var originalText = $btn.text();

        // Loading state
        $btn.prop('disabled', true);
        $btn.text('⏳ Scan en cours...');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'gar_scan_insuffle_blog',
                nonce: '<?php echo wp_create_nonce('gar_scan_blog'); ?>'
            },
            success: function(response) {
                $btn.prop('disabled', false);
                $btn.text(originalText);

                if (response.success) {
                    var data = response.data;
                    var html = '';

                    // Titres d'exemple
                    if (data.sample_titles && data.sample_titles.length > 0) {
                        html += '<h4>📚 Exemples de titres trouvés (' + data.sample_titles.length + ')</h4>';
                        html += '<ul>';
                        data.sample_titles.slice(0, 10).forEach(function(title) {
                            html += '<li><span class="gar-blog-title">' + title + '</span></li>';
                        });
                        html += '</ul>';

                        if (data.sample_titles.length > 10) {
                            html += '<p style="margin-top: 10px; opacity: 0.8;">... et ' + (data.sample_titles.length - 10) + ' autres titres</p>';
                        }
                    }

                    // Notes de style
                    if (data.style_notes) {
                        html += '<h4>✍️ Notes de style détectées</h4>';
                        html += '<p style="background: rgba(255,255,255,0.1); padding: 12px; border-radius: 6px; line-height: 1.6;">' +
                                data.style_notes + '</p>';
                    }

                    $('#gar-blog-content').html(html);
                    $('#gar-blog-results').slideDown(400);

                    // Afficher l'info de génération
                    $('#gar-generate-info').slideDown(400);

                    // Scroll vers les résultats
                    $('html, body').animate({
                        scrollTop: $('#gar-blog-results').offset().top - 50
                    }, 500);

                } else {
                    alert('❌ Erreur : ' + response.data);
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.text(originalText);
                alert('❌ Erreur de connexion');
            }
        });
    });

    // Générer de nouvelles idées
    $('#gar-generate-ideas').on('click', function() {
        var $btn = $(this);
        var originalText = $btn.text();
        var count = parseInt($('#gar-generate-count').val()) || 10;

        if (count < 1 || count > 50) {
            alert('⚠️ Veuillez entrer un nombre entre 1 et 50');
            return;
        }

        if (!confirm('Générer ' + count + ' nouvelles idées d\'articles ?\n\nElles seront ajoutées à votre liste d\'idées en attente.')) {
            return;
        }

        // Loading state
        $btn.prop('disabled', true);
        $btn.text('⏳ Génération en cours...');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'gar_generate_from_analysis',
                nonce: '<?php echo wp_create_nonce('gar_generate_ideas'); ?>',
                count: count
            },
            success: function(response) {
                $btn.prop('disabled', false);
                $btn.text(originalText);

                if (response.success) {
                    var data = response.data;

                    var html = '<div class="gar-success-message">';
                    html += '<h3>✅ ' + data.count + ' idées générées avec succès !</h3>';
                    html += '<p>Les nouvelles idées ont été ajoutées à votre liste. Rendez-vous dans <strong>Idées d\'Articles</strong> pour les consulter et les valider.</p>';
                    html += '<a href="admin.php?page=generateur-articles" class="button button-hero" style="margin-top: 20px; background: white; color: #11998e; border: none; font-weight: 600;">👉 Voir les idées</a>';
                    html += '</div>';

                    $('#gar-generate-content').html(html);
                    $('#gar-generate-results').slideDown(400);

                    // Scroll vers les résultats
                    $('html, body').animate({
                        scrollTop: $('#gar-generate-results').offset().top - 50
                    }, 500);

                } else {
                    alert('❌ Erreur : ' + response.data);
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.text(originalText);
                alert('❌ Erreur de connexion');
            }
        });
    });

});
</script>
