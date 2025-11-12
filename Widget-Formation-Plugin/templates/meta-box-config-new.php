<div class="wfm-config-container-v2">
    <div class="wfm-config-layout">
        <!-- Colonne gauche : Configuration -->
        <div class="wfm-config-left">
            <div class="wfm-section">
                <h3>🎯 Sélectionner les formations à afficher</h3>
                <p class="description">Cochez les formations que vous souhaitez afficher dans ce widget.</p>

                <div class="wfm-formations-list">
                    <?php if (!empty($all_formations)): ?>
                        <?php foreach ($all_formations as $formation): ?>
                            <label class="wfm-formation-item">
                                <input
                                    type="checkbox"
                                    name="wfm_formations[]"
                                    value="<?php echo $formation->ID; ?>"
                                    <?php checked(in_array($formation->ID, $formations)); ?>
                                    class="wfm-formation-checkbox"
                                >
                                <span class="formation-title"><?php echo esc_html($formation->post_title); ?></span>
                                <span class="formation-id">#<?php echo $formation->ID; ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="wfm-no-formations">Aucune formation trouvée. Les formations doivent être des pages enfants de la page ID 51.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="wfm-section">
                <h3>🎨 Style des cards</h3>
                <div class="wfm-style-selector">
                    <label class="wfm-style-option">
                        <input type="radio" name="wfm_card_style" value="modern" <?php checked($display_options['card_style'], 'modern'); ?>>
                        <div class="wfm-style-preview">
                            <span class="wfm-style-icon">🎨</span>
                            <span class="wfm-style-name">Modern</span>
                            <span class="wfm-style-desc">Gradient, ombres, effet hover</span>
                        </div>
                    </label>

                    <label class="wfm-style-option">
                        <input type="radio" name="wfm_card_style" value="minimal" <?php checked($display_options['card_style'], 'minimal'); ?>>
                        <div class="wfm-style-preview">
                            <span class="wfm-style-icon">✨</span>
                            <span class="wfm-style-name">Minimal</span>
                            <span class="wfm-style-desc">Épuré, sobre, élégant</span>
                        </div>
                    </label>

                    <label class="wfm-style-option">
                        <input type="radio" name="wfm_card_style" value="classic" <?php checked($display_options['card_style'], 'classic'); ?>>
                        <div class="wfm-style-preview">
                            <span class="wfm-style-icon">📋</span>
                            <span class="wfm-style-name">Classic</span>
                            <span class="wfm-style-desc">Classique, bordures, structuré</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="wfm-section">
                <h3>📝 Options d'affichage</h3>

                <label class="wfm-checkbox-option">
                    <input type="checkbox" name="wfm_show_excerpt" value="1" <?php checked($display_options['show_excerpt'], '1'); ?>>
                    <span class="wfm-option-content">
                        <strong>Afficher l'extrait de la formation</strong>
                        <span class="wfm-option-desc">Description courte sous le titre</span>
                    </span>
                </label>

                <label class="wfm-checkbox-option">
                    <input type="checkbox" name="wfm_show_formateur" value="1" <?php checked($display_options['show_formateur'], '1'); ?>>
                    <span class="wfm-option-content">
                        <strong>Afficher le formateur</strong>
                        <span class="wfm-option-desc">Nom du formateur avec icône</span>
                    </span>
                </label>

                <label class="wfm-checkbox-option">
                    <input type="checkbox" name="wfm_show_duree" value="1" <?php checked($display_options['show_duree'], '1'); ?>>
                    <span class="wfm-option-content">
                        <strong>Afficher la durée</strong>
                        <span class="wfm-option-desc">Durée de la formation (si renseignée)</span>
                    </span>
                </label>

                <label class="wfm-checkbox-option">
                    <input type="checkbox" name="wfm_show_prix" value="1" <?php checked($display_options['show_prix'], '1'); ?>>
                    <span class="wfm-option-content">
                        <strong>Afficher le prix</strong>
                        <span class="wfm-option-desc">Prix de la formation (si renseigné)</span>
                    </span>
                </label>

                <div class="wfm-input-group">
                    <label><strong>Texte du bouton CTA</strong></label>
                    <input
                        type="text"
                        name="wfm_cta_text"
                        value="<?php echo esc_attr($display_options['show_cta_text']); ?>"
                        class="regular-text"
                        placeholder="En savoir plus"
                    >
                    <p class="description">Texte affiché sur le bouton d'action</p>
                </div>
            </div>

            <div class="wfm-section">
                <h3>🎨 Logos</h3>

                <label class="wfm-checkbox-option">
                    <input type="checkbox" name="wfm_show_logo_ia" value="1" <?php checked($show_logo_ia, '1'); ?>>
                    <span class="wfm-option-content">
                        <strong>Afficher le logo Insufflé Académie</strong>
                    </span>
                </label>

                <label class="wfm-checkbox-option">
                    <input type="checkbox" name="wfm_show_logo_qualiopi" value="1" <?php checked($show_logo_qualiopi, '1'); ?>>
                    <span class="wfm-option-content">
                        <strong>Afficher le logo Qualiopi</strong>
                    </span>
                </label>
            </div>
        </div>

        <!-- Colonne droite : Prévisualisation -->
        <div class="wfm-config-right">
            <div class="wfm-preview-sticky">
                <h3>👁️ Prévisualisation en direct</h3>
                <p class="description">Aperçu du widget avec vos paramètres</p>

                <div id="wfm-live-preview" class="wfm-live-preview">
                    <div class="wfm-preview-loading">
                        <span class="spinner is-active"></span>
                        <p>Chargement de la prévisualisation...</p>
                    </div>
                </div>

                <div class="wfm-preview-actions">
                    <button type="button" class="button button-secondary" id="wfm-refresh-preview">
                        🔄 Rafraîchir la prévisualisation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="wfm-info-section">
        <h4>ℹ️ Comment ça fonctionne ?</h4>
        <ul>
            <li><strong>Sélectionnez les formations</strong> que vous voulez afficher dans le widget</li>
            <li><strong>Choisissez le style</strong> des cards (Modern, Minimal, Classic)</li>
            <li><strong>Activez/désactivez les options</strong> d'affichage selon vos besoins</li>
            <li><strong>La prévisualisation</strong> se met à jour automatiquement</li>
            <li><strong>Publiez</strong> pour générer le code d'intégration</li>
        </ul>
    </div>
</div>

<style>
.wfm-config-container-v2 {
    max-width: 100%;
}

.wfm-config-layout {
    display: grid;
    grid-template-columns: 1fr 500px;
    gap: 30px;
    margin-bottom: 30px;
}

.wfm-config-left {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.wfm-config-right {
    position: relative;
}

.wfm-preview-sticky {
    position: sticky;
    top: 32px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.wfm-preview-sticky h3 {
    margin-top: 0;
    margin-bottom: 10px;
}

.wfm-live-preview {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
    min-height: 400px;
    background: #f9f9f9;
    margin: 20px 0;
    overflow: auto;
    max-height: 600px;
}

.wfm-preview-loading {
    text-align: center;
    padding: 60px 20px;
}

.wfm-preview-loading .spinner {
    float: none;
    margin: 0 auto 20px;
}

.wfm-preview-actions {
    text-align: center;
}

.wfm-section {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #8E2183;
}

.wfm-section h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #8E2183;
    font-size: 15px;
}

.wfm-formations-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
    margin-top: 15px;
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 6px;
}

.wfm-formation-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: white;
    border: 2px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.wfm-formation-item:hover {
    border-color: #8E2183;
    background: #fafafa;
}

.wfm-formation-item input[type="checkbox"] {
    margin: 0;
    cursor: pointer;
    accent-color: #8E2183;
}

.wfm-formation-item .formation-title {
    flex: 1;
    font-weight: 600;
    font-size: 13px;
    color: #333;
}

.wfm-formation-item .formation-id {
    font-size: 11px;
    color: #999;
}

.wfm-style-selector {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 15px;
}

.wfm-style-option {
    position: relative;
    cursor: pointer;
}

.wfm-style-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.wfm-style-preview {
    border: 2px solid #ddd;
    border-radius: 8px;
    padding: 20px 15px;
    text-align: center;
    transition: all 0.2s ease;
    background: white;
}

.wfm-style-option input[type="radio"]:checked + .wfm-style-preview {
    border-color: #8E2183;
    background: #f8f4f9;
    box-shadow: 0 0 0 3px rgba(142,33,131,0.1);
}

.wfm-style-preview:hover {
    border-color: #8E2183;
}

.wfm-style-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 10px;
}

.wfm-style-name {
    display: block;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.wfm-style-desc {
    display: block;
    font-size: 11px;
    color: #666;
}

.wfm-checkbox-option {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px;
    background: #f9f9f9;
    border-radius: 6px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.wfm-checkbox-option:hover {
    background: #f0f0f0;
}

.wfm-checkbox-option input[type="checkbox"] {
    margin-top: 2px;
    cursor: pointer;
    accent-color: #8E2183;
}

.wfm-option-content {
    flex: 1;
}

.wfm-option-content strong {
    display: block;
    color: #333;
    margin-bottom: 3px;
}

.wfm-option-desc {
    display: block;
    font-size: 12px;
    color: #666;
}

.wfm-input-group {
    margin-top: 15px;
}

.wfm-input-group label {
    display: block;
    margin-bottom: 8px;
}

.wfm-info-section {
    background: #e7f3ff;
    border-left: 4px solid #2271b1;
    padding: 20px;
    border-radius: 8px;
}

.wfm-info-section h4 {
    margin-top: 0;
    color: #2271b1;
}

.wfm-info-section ul {
    margin: 10px 0 0 20px;
}

.wfm-info-section li {
    margin-bottom: 8px;
    line-height: 1.6;
}

.wfm-no-formations {
    padding: 40px 20px;
    text-align: center;
    color: #666;
    background: white;
    border-radius: 8px;
}

@media (max-width: 1400px) {
    .wfm-config-layout {
        grid-template-columns: 1fr;
    }

    .wfm-preview-sticky {
        position: static;
    }
}

@media (max-width: 768px) {
    .wfm-style-selector {
        grid-template-columns: 1fr;
    }

    .wfm-formations-list {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Auto-update preview on any change
    var previewTimeout;

    function updatePreview() {
        clearTimeout(previewTimeout);
        previewTimeout = setTimeout(function() {
            loadPreview();
        }, 500);
    }

    $('.wfm-formation-checkbox, input[name="wfm_card_style"], input[name^="wfm_show_"], input[name="wfm_cta_text"]').on('change input', updatePreview);

    $('#wfm-refresh-preview').on('click', function() {
        loadPreview();
    });

    function loadPreview() {
        var $preview = $('#wfm-live-preview');
        $preview.html('<div class="wfm-preview-loading"><span class="spinner is-active"></span><p>Mise à jour...</p></div>');

        // Simuler un chargement (à remplacer par un vrai appel AJAX si nécessaire)
        setTimeout(function() {
            var selectedFormations = $('.wfm-formation-checkbox:checked').length;
            var cardStyle = $('input[name="wfm_card_style"]:checked').val();
            var showExcerpt = $('input[name="wfm_show_excerpt"]').is(':checked');
            var showFormateur = $('input[name="wfm_show_formateur"]').is(':checked');
            var ctaText = $('input[name="wfm_cta_text"]').val() || 'En savoir plus';

            var html = '<div style="background: linear-gradient(135deg, rgba(142,33,131,0.95) 0%, rgba(165,42,154,0.95) 100%); padding: 30px; border-radius: 20px; color: white;">';
            html += '<h3 style="margin: 0 0 20px; text-align: center; color: white;">Aperçu du widget</h3>';

            if (selectedFormations === 0) {
                html += '<p style="text-align: center; opacity: 0.9;">Sélectionnez au moins une formation pour voir la prévisualisation.</p>';
            } else {
                html += '<p style="text-align: center; margin-bottom: 20px; opacity: 0.9;">' + selectedFormations + ' formation(s) sélectionnée(s)</p>';
                html += '<div style="background: white; color: #333; padding: 25px; border-radius: 15px; margin-bottom: 15px;">';
                html += '<h4 style="color: #8E2183; margin: 0 0 10px;">Exemple de formation</h4>';
                if (showExcerpt) {
                    html += '<p style="margin: 0 0 15px; font-size: 14px; color: #666;">Description courte de la formation qui donne envie d\'en savoir plus...</p>';
                }
                html += '<div style="display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap; font-size: 13px;">';
                if (showFormateur) {
                    html += '<span style="color: #666;">👤 Yann Lhureault</span>';
                }
                html += '</div>';
                html += '<a href="#" style="background: linear-gradient(135deg, #8E2183 0%, #a52a9a 100%); color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; display: inline-block; font-weight: 600;">' + ctaText + ' →</a>';
                html += '</div>';
                html += '<p style="text-align: center; font-size: 12px; opacity: 0.8; margin: 15px 0 0;">Style: <strong>' + cardStyle + '</strong></p>';
            }

            html += '</div>';

            $preview.html(html);
        }, 300);
    }

    // Load preview on page load
    loadPreview();
});
</script>
