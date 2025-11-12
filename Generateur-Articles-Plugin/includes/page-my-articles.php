<?php
/**
 * Page: Mes Articles
 * Liste tous les articles existants pour analyse
 */

if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1>📚 Mes Articles Publiés</h1>
    <p class="description">Analysez vos articles existants pour générer de nouvelles idées dans votre style.</p>

    <!-- Stats rapides -->
    <div class="gar-header">
        <div class="gar-stats">
            <div class="gar-stat-box gar-total">
                <div class="gar-stat-number"><?php echo count($articles); ?></div>
                <div class="gar-stat-label">Articles publiés</div>
            </div>
            <?php
            $total_words = 0;
            foreach ($articles as $article) {
                $total_words += str_word_count(strip_tags($article->post_content));
            }
            $avg_words = count($articles) > 0 ? round($total_words / count($articles)) : 0;
            ?>
            <div class="gar-stat-box gar-pending">
                <div class="gar-stat-number"><?php echo number_format($total_words); ?></div>
                <div class="gar-stat-label">Mots au total</div>
            </div>
            <div class="gar-stat-box gar-published">
                <div class="gar-stat-number"><?php echo number_format($avg_words); ?></div>
                <div class="gar-stat-label">Mots en moyenne</div>
            </div>
        </div>
        <div>
            <button type="button" id="gar-analyze-articles" class="button button-primary button-hero">
                🔍 Analyser mes articles
            </button>
        </div>
    </div>

    <!-- Zone de résultats d'analyse -->
    <div id="gar-analysis-results" style="display: none; margin: 20px 0;">
        <div class="gar-idea-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h2 style="color: white; margin-top: 0;">✨ Résultats de l'analyse</h2>
            <div id="gar-analysis-content">
                <!-- Rempli via AJAX -->
            </div>
        </div>
    </div>

    <!-- Liste des articles -->
    <?php if (empty($articles)): ?>
        <div class="gar-no-results">
            <p>Aucun article publié pour le moment.</p>
            <p>Commencez par valider des idées d'articles dans l'onglet "Idées d'Articles" !</p>
        </div>
    <?php else: ?>
        <div class="gar-articles-table">
            <table class="wp-list-table widefat fixed striped" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="width: 50%;">Titre</th>
                        <th>Date</th>
                        <th>Mots</th>
                        <th>Catégories</th>
                        <th>Tags</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article):
                        $word_count = str_word_count(strip_tags($article->post_content));
                        $categories = get_the_category($article->ID);
                        $tags = get_the_tags($article->ID);
                    ?>
                        <tr>
                            <td>
                                <strong>
                                    <a href="<?php echo get_edit_post_link($article->ID); ?>" target="_blank">
                                        <?php echo esc_html($article->post_title); ?>
                                    </a>
                                </strong>
                                <div style="color: #666; font-size: 0.9em; margin-top: 5px;">
                                    <?php echo wp_trim_words($article->post_excerpt ?: $article->post_content, 20); ?>
                                </div>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($article->post_date)); ?></td>
                            <td><?php echo number_format($word_count); ?></td>
                            <td>
                                <?php
                                if ($categories) {
                                    echo implode(', ', array_map(function($cat) {
                                        return $cat->name;
                                    }, $categories));
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($tags) {
                                    echo implode(', ', array_map(function($tag) {
                                        return $tag->name;
                                    }, array_slice($tags, 0, 3)));
                                    if (count($tags) > 3) echo '...';
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo get_permalink($article->ID); ?>" target="_blank" class="button button-small">
                                    👁️ Voir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Info sur l'analyse -->
    <div class="gar-idea-card" style="margin-top: 30px; background: #f9f9f9;">
        <h3>💡 Comment fonctionne l'analyse ?</h3>
        <ul>
            <li><strong>Nombre de mots :</strong> Calcule la longueur moyenne de vos articles</li>
            <li><strong>Thèmes récurrents :</strong> Identifie les sujets que vous abordez le plus</li>
            <li><strong>Catégories et tags :</strong> Analyse vos thématiques favorites</li>
            <li><strong>Style d'écriture :</strong> Détecte votre ton, structure et vocabulaire</li>
        </ul>
        <p>Une fois l'analyse terminée, allez dans <strong>"Analyser mon style"</strong> pour scanner également le blog Insufflé et générer de nouvelles idées d'articles personnalisées.</p>
    </div>
</div>

<style>
.gar-articles-table {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.gar-articles-table table {
    border-radius: 8px;
    overflow: hidden;
}

.gar-articles-table th {
    background: #8E2183;
    color: white;
    font-weight: 600;
    padding: 12px !important;
}

.gar-articles-table td {
    padding: 12px !important;
    vertical-align: top;
}

.gar-articles-table tr:hover {
    background: #f5f5f5;
}

#gar-analysis-results {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#gar-analysis-content {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 8px;
    margin-top: 15px;
}

#gar-analysis-content h3 {
    color: white;
    margin-top: 20px;
    margin-bottom: 10px;
    font-size: 1.2em;
}

#gar-analysis-content h3:first-child {
    margin-top: 0;
}

#gar-analysis-content ul {
    list-style: none;
    padding: 0;
    margin: 10px 0;
}

#gar-analysis-content ul li {
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.15);
    margin-bottom: 8px;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#gar-analysis-content ul li strong {
    color: #fff;
}

#gar-analysis-content .gar-theme-count {
    background: rgba(255, 255, 255, 0.3);
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.9em;
    font-weight: bold;
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#gar-analyze-articles').on('click', function() {
        var $btn = $(this);
        var originalText = $btn.text();

        // Loading state
        $btn.prop('disabled', true);
        $btn.text('⏳ Analyse en cours...');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'gar_scan_existing_articles',
                nonce: '<?php echo wp_create_nonce('gar_scan_articles'); ?>'
            },
            success: function(response) {
                $btn.prop('disabled', false);
                $btn.text(originalText);

                if (response.success) {
                    var data = response.data;

                    // Construire le HTML des résultats
                    var html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 20px;">';
                    html += '<div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; text-align: center;">';
                    html += '<div style="font-size: 2em; font-weight: bold;">' + data.total_articles + '</div>';
                    html += '<div>Articles analysés</div>';
                    html += '</div>';
                    html += '<div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; text-align: center;">';
                    html += '<div style="font-size: 2em; font-weight: bold;">' + data.total_words.toLocaleString() + '</div>';
                    html += '<div>Mots au total</div>';
                    html += '</div>';
                    html += '<div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; text-align: center;">';
                    html += '<div style="font-size: 2em; font-weight: bold;">' + Math.round(data.avg_words).toLocaleString() + '</div>';
                    html += '<div>Mots par article</div>';
                    html += '</div>';
                    html += '</div>';

                    // Thèmes communs
                    if (data.common_themes && data.common_themes.length > 0) {
                        html += '<h3>🎯 Thèmes les plus abordés</h3>';
                        html += '<ul>';
                        data.common_themes.forEach(function(theme) {
                            html += '<li>';
                            html += '<strong>' + theme.name + '</strong>';
                            html += '<span class="gar-theme-count">' + theme.count + ' articles</span>';
                            html += '</li>';
                        });
                        html += '</ul>';
                    }

                    // Tags populaires
                    if (data.popular_tags && data.popular_tags.length > 0) {
                        html += '<h3>🏷️ Tags les plus utilisés</h3>';
                        html += '<ul>';
                        data.popular_tags.forEach(function(tag) {
                            html += '<li>';
                            html += '<strong>' + tag.name + '</strong>';
                            html += '<span class="gar-theme-count">' + tag.count + '</span>';
                            html += '</li>';
                        });
                        html += '</ul>';
                    }

                    $('#gar-analysis-content').html(html);
                    $('#gar-analysis-results').slideDown(400);

                    // Scroll vers les résultats
                    $('html, body').animate({
                        scrollTop: $('#gar-analysis-results').offset().top - 50
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
