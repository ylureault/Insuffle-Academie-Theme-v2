<?php
/**
 * Template: Configuration professionnelle du widget
 * Version PRO avec toutes les options
 */

if (!defined('ABSPATH')) exit;
?>

<div class="wfm-pro-config">
    <div class="wfm-pro-layout">
        <!-- Colonne gauche : Configuration complète -->
        <div class="wfm-pro-left">

            <!-- Section 1: Sélection des formations -->
            <div class="wfm-pro-section">
                <div class="wfm-pro-section-header">
                    <span class="wfm-pro-icon">🎯</span>
                    <h3>Formations à afficher</h3>
                </div>
                <p class="wfm-pro-desc">Sélectionnez les formations que vous souhaitez proposer dans ce widget</p>

                <div class="wfm-formations-grid">
                    <?php if (!empty($all_formations)): ?>
                        <?php foreach ($all_formations as $formation): ?>
                            <label class="wfm-formation-card <?php echo in_array($formation->ID, $formations) ? 'selected' : ''; ?>">
                                <input
                                    type="checkbox"
                                    name="wfm_formations[]"
                                    value="<?php echo $formation->ID; ?>"
                                    <?php checked(in_array($formation->ID, $formations)); ?>
                                    class="wfm-formation-checkbox"
                                    data-formation-id="<?php echo $formation->ID; ?>"
                                >
                                <div class="wfm-formation-content">
                                    <div class="wfm-formation-title"><?php echo esc_html($formation->post_title); ?></div>
                                    <div class="wfm-formation-meta">
                                        <span class="wfm-formation-id">ID: <?php echo $formation->ID; ?></span>
                                        <?php
                                        $excerpt = $formation->post_excerpt ? $formation->post_excerpt : wp_trim_words($formation->post_content, 15);
                                        if ($excerpt): ?>
                                            <span class="wfm-formation-excerpt"><?php echo esc_html($excerpt); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="wfm-formation-check">✓</div>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="wfm-no-data">Aucune formation trouvée. Les formations doivent être des pages enfants de la page ID 51.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Section 2: Éléments à afficher -->
            <div class="wfm-pro-section">
                <div class="wfm-pro-section-header">
                    <span class="wfm-pro-icon">📋</span>
                    <h3>Éléments à afficher</h3>
                </div>
                <p class="wfm-pro-desc">Choisissez les informations à afficher sur chaque carte de formation</p>

                <div class="wfm-checkboxes-grid">
                    <label class="wfm-checkbox-item">
                        <input type="checkbox" name="wfm_show_excerpt" <?php checked($display_options['show_excerpt'], '1'); ?>>
                        <div class="wfm-checkbox-content">
                            <span class="wfm-checkbox-icon">📝</span>
                            <span class="wfm-checkbox-label">Extrait / Description</span>
                        </div>
                    </label>

                    <label class="wfm-checkbox-item">
                        <input type="checkbox" name="wfm_show_formateur" <?php checked($display_options['show_formateur'], '1'); ?>>
                        <div class="wfm-checkbox-content">
                            <span class="wfm-checkbox-icon">👤</span>
                            <span class="wfm-checkbox-label">Formateur</span>
                        </div>
                    </label>

                    <label class="wfm-checkbox-item">
                        <input type="checkbox" name="wfm_show_duree" <?php checked($display_options['show_duree'], '1'); ?>>
                        <div class="wfm-checkbox-content">
                            <span class="wfm-checkbox-icon">⏱️</span>
                            <span class="wfm-checkbox-label">Durée</span>
                        </div>
                    </label>

                    <label class="wfm-checkbox-item">
                        <input type="checkbox" name="wfm_show_prix" <?php checked($display_options['show_prix'], '1'); ?>>
                        <div class="wfm-checkbox-content">
                            <span class="wfm-checkbox-icon">💰</span>
                            <span class="wfm-checkbox-label">Prix</span>
                        </div>
                    </label>

                    <label class="wfm-checkbox-item">
                        <input type="checkbox" name="wfm_show_modules_count" <?php checked($display_options['show_modules_count'], '1'); ?>>
                        <div class="wfm-checkbox-content">
                            <span class="wfm-checkbox-icon">📚</span>
                            <span class="wfm-checkbox-label">Nombre de modules</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Section 3: Style & Couleurs -->
            <div class="wfm-pro-section">
                <div class="wfm-pro-section-header">
                    <span class="wfm-pro-icon">🎨</span>
                    <h3>Style & Couleurs</h3>
                </div>
                <p class="wfm-pro-desc">Personnalisez l'apparence des cartes de formation</p>

                <div class="wfm-style-selector">
                    <label class="wfm-style-card <?php echo $display_options['card_style'] === 'insuffle' ? 'active' : ''; ?>">
                        <input type="radio" name="wfm_card_style" value="insuffle" <?php checked($display_options['card_style'], 'insuffle'); ?>>
                        <div class="wfm-style-preview insuffle-preview">
                            <div class="preview-header" style="background: linear-gradient(135deg, #8E2183 0%, #E91E63 100%);">
                                <div class="preview-badge">Insufflé Académie</div>
                            </div>
                            <div class="preview-content">
                                <div class="preview-title">Style Insufflé</div>
                                <div class="preview-desc">Design officiel avec gradients violet/rose</div>
                            </div>
                        </div>
                        <span class="wfm-style-name">🏆 Insufflé Académie</span>
                    </label>

                    <label class="wfm-style-card <?php echo $display_options['card_style'] === 'modern' ? 'active' : ''; ?>">
                        <input type="radio" name="wfm_card_style" value="modern" <?php checked($display_options['card_style'], 'modern'); ?>>
                        <div class="wfm-style-preview modern-preview">
                            <div class="preview-content">
                                <div class="preview-title">Style Modern</div>
                                <div class="preview-desc">Épuré avec ombres et arrondis</div>
                            </div>
                        </div>
                        <span class="wfm-style-name">✨ Modern</span>
                    </label>

                    <label class="wfm-style-card <?php echo $display_options['card_style'] === 'minimal' ? 'active' : ''; ?>">
                        <input type="radio" name="wfm_card_style" value="minimal" <?php checked($display_options['card_style'], 'minimal'); ?>>
                        <div class="wfm-style-preview minimal-preview">
                            <div class="preview-content">
                                <div class="preview-title">Style Minimal</div>
                                <div class="preview-desc">Sobre et élégant</div>
                            </div>
                        </div>
                        <span class="wfm-style-name">🎯 Minimal</span>
                    </label>
                </div>

                <div class="wfm-colors-grid">
                    <div class="wfm-color-picker">
                        <label>Couleur de fond des cartes</label>
                        <input type="color" name="wfm_bg_color" value="<?php echo esc_attr($display_options['bg_color']); ?>">
                        <input type="text" class="color-value" value="<?php echo esc_attr($display_options['bg_color']); ?>" readonly>
                    </div>

                    <div class="wfm-color-picker">
                        <label>Couleur du texte</label>
                        <input type="color" name="wfm_text_color" value="<?php echo esc_attr($display_options['text_color']); ?>">
                        <input type="text" class="color-value" value="<?php echo esc_attr($display_options['text_color']); ?>" readonly>
                    </div>

                    <div class="wfm-color-picker">
                        <label>Couleur d'accent (Insufflé)</label>
                        <input type="color" name="wfm_accent_color" value="<?php echo esc_attr($display_options['accent_color']); ?>">
                        <input type="text" class="color-value" value="<?php echo esc_attr($display_options['accent_color']); ?>" readonly>
                    </div>
                </div>
            </div>

            <!-- Section 4: CTA (Call-to-Action) -->
            <div class="wfm-pro-section">
                <div class="wfm-pro-section-header">
                    <span class="wfm-pro-icon">🚀</span>
                    <h3>Bouton d'action (CTA)</h3>
                </div>
                <p class="wfm-pro-desc">Personnalisez le bouton qui convertit vos visiteurs en leads</p>

                <div class="wfm-cta-config">
                    <div class="wfm-input-group">
                        <label>Texte du bouton</label>
                        <input type="text" name="wfm_cta_text" value="<?php echo esc_attr($cta_options['text']); ?>" placeholder="Ex: Découvrir la formation">
                    </div>

                    <div class="wfm-cta-style-selector">
                        <label>Style du bouton</label>
                        <div class="wfm-cta-styles">
                            <label class="wfm-cta-style-option">
                                <input type="radio" name="wfm_cta_style" value="solid" <?php checked($cta_options['style'], 'solid'); ?>>
                                <span class="wfm-cta-preview solid">Plein</span>
                            </label>

                            <label class="wfm-cta-style-option">
                                <input type="radio" name="wfm_cta_style" value="outline" <?php checked($cta_options['style'], 'outline'); ?>>
                                <span class="wfm-cta-preview outline">Contour</span>
                            </label>

                            <label class="wfm-cta-style-option">
                                <input type="radio" name="wfm_cta_style" value="gradient" <?php checked($cta_options['style'], 'gradient'); ?>>
                                <span class="wfm-cta-preview gradient">Gradient</span>
                            </label>
                        </div>
                    </div>

                    <div class="wfm-colors-grid">
                        <div class="wfm-color-picker">
                            <label>Couleur de fond</label>
                            <input type="color" name="wfm_cta_bg_color" value="<?php echo esc_attr($cta_options['bg_color']); ?>">
                            <input type="text" class="color-value" value="<?php echo esc_attr($cta_options['bg_color']); ?>" readonly>
                        </div>

                        <div class="wfm-color-picker">
                            <label>Couleur du texte</label>
                            <input type="color" name="wfm_cta_text_color" value="<?php echo esc_attr($cta_options['text_color']); ?>">
                            <input type="text" class="color-value" value="<?php echo esc_attr($cta_options['text_color']); ?>" readonly>
                        </div>

                        <div class="wfm-color-picker">
                            <label>Couleur au survol</label>
                            <input type="color" name="wfm_cta_hover_bg_color" value="<?php echo esc_attr($cta_options['hover_bg_color']); ?>">
                            <input type="text" class="color-value" value="<?php echo esc_attr($cta_options['hover_bg_color']); ?>" readonly>
                        </div>
                    </div>

                    <div class="wfm-input-group">
                        <label>Ouvrir le lien dans</label>
                        <select name="wfm_cta_target">
                            <option value="_blank" <?php selected($cta_options['target'], '_blank'); ?>>Nouvel onglet (_blank)</option>
                            <option value="_self" <?php selected($cta_options['target'], '_self'); ?>>Même fenêtre (_self)</option>
                            <option value="_parent" <?php selected($cta_options['target'], '_parent'); ?>>Fenêtre parente (_parent)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 5: Logos -->
            <div class="wfm-pro-section">
                <div class="wfm-pro-section-header">
                    <span class="wfm-pro-icon">🏷️</span>
                    <h3>Logos & Certifications</h3>
                </div>
                <p class="wfm-pro-desc">Ajoutez vos logos pour renforcer la crédibilité (Insufflé Académie, Qualiopi, partenaires)</p>

                <div class="wfm-logos-config">
                    <!-- Logo Insufflé Académie -->
                    <div class="wfm-logo-item">
                        <div class="wfm-logo-header">
                            <label class="wfm-logo-toggle">
                                <input type="checkbox" name="wfm_show_logo_ia" <?php checked($logo_options['show_logo_ia'], '1'); ?>>
                                <span>Afficher le logo Insufflé Académie</span>
                            </label>
                        </div>
                        <div class="wfm-logo-upload">
                            <input type="hidden" name="wfm_logo_ia_id" class="wfm-logo-id" value="<?php echo esc_attr($logo_options['logo_ia_id']); ?>">
                            <div class="wfm-logo-preview">
                                <?php if ($logo_options['logo_ia_id']): ?>
                                    <img src="<?php echo wp_get_attachment_image_url($logo_options['logo_ia_id'], 'thumbnail'); ?>" alt="Logo Insufflé Académie">
                                <?php else: ?>
                                    <span class="wfm-logo-placeholder">Aucun logo</span>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="wfm-upload-logo button">Choisir un logo</button>
                            <?php if ($logo_options['logo_ia_id']): ?>
                                <button type="button" class="wfm-remove-logo button">Retirer</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Logo Qualiopi -->
                    <div class="wfm-logo-item">
                        <div class="wfm-logo-header">
                            <label class="wfm-logo-toggle">
                                <input type="checkbox" name="wfm_show_logo_qualiopi" <?php checked($logo_options['show_logo_qualiopi'], '1'); ?>>
                                <span>Afficher le logo Qualiopi</span>
                            </label>
                        </div>
                        <div class="wfm-logo-upload">
                            <input type="hidden" name="wfm_logo_qualiopi_id" class="wfm-logo-id" value="<?php echo esc_attr($logo_options['logo_qualiopi_id']); ?>">
                            <div class="wfm-logo-preview">
                                <?php if ($logo_options['logo_qualiopi_id']): ?>
                                    <img src="<?php echo wp_get_attachment_image_url($logo_options['logo_qualiopi_id'], 'thumbnail'); ?>" alt="Logo Qualiopi">
                                <?php else: ?>
                                    <span class="wfm-logo-placeholder">Aucun logo</span>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="wfm-upload-logo button">Choisir un logo</button>
                            <?php if ($logo_options['logo_qualiopi_id']): ?>
                                <button type="button" class="wfm-remove-logo button">Retirer</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Logo personnalisé -->
                    <div class="wfm-logo-item">
                        <div class="wfm-logo-header">
                            <label class="wfm-logo-toggle">
                                <input type="checkbox" name="wfm_show_logo_custom" <?php checked($logo_options['show_logo_custom'], '1'); ?>>
                                <span>Afficher un logo personnalisé (partenaire, etc.)</span>
                            </label>
                        </div>
                        <div class="wfm-logo-upload">
                            <input type="hidden" name="wfm_logo_custom_id" class="wfm-logo-id" value="<?php echo esc_attr($logo_options['logo_custom_id']); ?>">
                            <div class="wfm-logo-preview">
                                <?php if ($logo_options['logo_custom_id']): ?>
                                    <img src="<?php echo wp_get_attachment_image_url($logo_options['logo_custom_id'], 'thumbnail'); ?>" alt="Logo personnalisé">
                                <?php else: ?>
                                    <span class="wfm-logo-placeholder">Aucun logo</span>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="wfm-upload-logo button">Choisir un logo</button>
                            <?php if ($logo_options['logo_custom_id']): ?>
                                <button type="button" class="wfm-remove-logo button">Retirer</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="wfm-input-group">
                        <label>Position des logos</label>
                        <select name="wfm_logos_position">
                            <option value="top" <?php selected($logo_options['logos_position'], 'top'); ?>>En haut des cartes</option>
                            <option value="bottom" <?php selected($logo_options['logos_position'], 'bottom'); ?>>En bas des cartes</option>
                            <option value="both" <?php selected($logo_options['logos_position'], 'both'); ?>>En haut ET en bas</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <!-- Colonne droite : Aperçu en temps réel -->
        <div class="wfm-pro-right">
            <div class="wfm-pro-preview-sticky">
                <div class="wfm-pro-preview-header">
                    <span class="wfm-pro-icon">👁️</span>
                    <h3>Aperçu en temps réel</h3>
                    <button type="button" class="wfm-refresh-preview button button-small">🔄 Actualiser</button>
                </div>
                <div id="wfm-preview-container" class="wfm-preview-container">
                    <div class="wfm-preview-loading">
                        <div class="wfm-spinner"></div>
                        <p>Sélectionnez une formation pour voir l'aperçu...</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.wfm-pro-config {
    margin: 20px 0;
}

.wfm-pro-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 30px;
}

/* Section commune */
.wfm-pro-section {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.wfm-pro-section-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.wfm-pro-section-header h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.wfm-pro-icon {
    font-size: 24px;
}

.wfm-pro-desc {
    color: #666;
    margin: 0 0 20px 0;
    font-size: 14px;
    line-height: 1.5;
}

/* Formations grid */
.wfm-formations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
}

.wfm-formation-card {
    position: relative;
    display: flex;
    align-items: center;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.wfm-formation-card:hover {
    border-color: #8E2183;
    box-shadow: 0 4px 12px rgba(142, 33, 131, 0.15);
}

.wfm-formation-card.selected {
    border-color: #8E2183;
    background: linear-gradient(135deg, rgba(142, 33, 131, 0.05) 0%, rgba(233, 30, 99, 0.05) 100%);
}

.wfm-formation-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.wfm-formation-content {
    flex: 1;
}

.wfm-formation-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.wfm-formation-meta {
    font-size: 12px;
    color: #666;
}

.wfm-formation-id {
    background: #f0f0f0;
    padding: 2px 6px;
    border-radius: 3px;
    margin-right: 8px;
}

.wfm-formation-check {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #8E2183;
    color: white;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
}

.wfm-formation-card.selected .wfm-formation-check {
    display: flex;
}

/* Checkboxes grid */
.wfm-checkboxes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.wfm-checkbox-item {
    display: block;
    position: relative;
}

.wfm-checkbox-item input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}

.wfm-checkbox-content {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.wfm-checkbox-item input[type="checkbox"]:checked + .wfm-checkbox-content {
    border-color: #8E2183;
    background: rgba(142, 33, 131, 0.05);
}

.wfm-checkbox-icon {
    font-size: 20px;
}

.wfm-checkbox-label {
    font-weight: 500;
    color: #333;
}

/* Style selector */
.wfm-style-selector {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.wfm-style-card {
    display: block;
    position: relative;
    cursor: pointer;
}

.wfm-style-card input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.wfm-style-preview {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 120px;
}

.wfm-style-card.active .wfm-style-preview,
.wfm-style-card input[type="radio"]:checked ~ .wfm-style-preview {
    border-color: #8E2183;
    box-shadow: 0 4px 12px rgba(142, 33, 131, 0.2);
}

.wfm-style-name {
    display: block;
    text-align: center;
    margin-top: 8px;
    font-weight: 600;
    color: #333;
}

.preview-header {
    padding: 10px;
    color: white;
}

.preview-badge {
    font-size: 11px;
    font-weight: bold;
}

.preview-content {
    padding: 10px;
}

.preview-title {
    font-weight: bold;
    margin-bottom: 5px;
}

.preview-desc {
    font-size: 12px;
    color: #666;
}

/* Colors grid */
.wfm-colors-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.wfm-color-picker {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.wfm-color-picker label {
    font-size: 13px;
    font-weight: 500;
    color: #555;
}

.wfm-color-picker input[type="color"] {
    width: 100%;
    height: 50px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    cursor: pointer;
}

.wfm-color-picker .color-value {
    font-family: monospace;
    text-align: center;
    padding: 5px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 12px;
    background: #f9f9f9;
}

/* CTA Config */
.wfm-cta-config {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.wfm-input-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #555;
}

.wfm-input-group input[type="text"],
.wfm-input-group select {
    width: 100%;
    padding: 10px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 14px;
}

.wfm-cta-styles {
    display: flex;
    gap: 10px;
}

.wfm-cta-style-option {
    flex: 1;
}

.wfm-cta-style-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.wfm-cta-preview {
    display: block;
    padding: 12px 20px;
    text-align: center;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.wfm-cta-preview.solid {
    background: #8E2183;
    color: white;
    border: 2px solid #8E2183;
}

.wfm-cta-preview.outline {
    background: transparent;
    color: #8E2183;
    border: 2px solid #8E2183;
}

.wfm-cta-preview.gradient {
    background: linear-gradient(135deg, #8E2183 0%, #E91E63 100%);
    color: white;
    border: 2px solid transparent;
}

.wfm-cta-style-option input[type="radio"]:checked ~ .wfm-cta-preview {
    box-shadow: 0 4px 12px rgba(142, 33, 131, 0.3);
    transform: translateY(-2px);
}

/* Logos config */
.wfm-logos-config {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.wfm-logo-item {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    background: #f9f9f9;
}

.wfm-logo-header {
    margin-bottom: 15px;
}

.wfm-logo-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    cursor: pointer;
}

.wfm-logo-upload {
    display: flex;
    align-items: center;
    gap: 10px;
}

.wfm-logo-preview {
    width: 80px;
    height: 80px;
    border: 2px dashed #ccc;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
}

.wfm-logo-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.wfm-logo-placeholder {
    font-size: 11px;
    color: #999;
    text-align: center;
}

/* Preview */
.wfm-pro-right {
    position: relative;
}

.wfm-pro-preview-sticky {
    position: sticky;
    top: 32px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.wfm-pro-preview-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    background: linear-gradient(135deg, #8E2183 0%, #E91E63 100%);
    color: white;
}

.wfm-pro-preview-header h3 {
    margin: 0;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.wfm-preview-container {
    padding: 20px;
    min-height: 400px;
    background: rgba(0,0,0,0.02);
}

.wfm-preview-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 300px;
    color: #666;
}

.wfm-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #8E2183;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.wfm-no-data {
    text-align: center;
    padding: 40px 20px;
    color: #666;
    background: #f9f9f9;
    border-radius: 8px;
}

/* Responsive */
@media (max-width: 1400px) {
    .wfm-pro-layout {
        grid-template-columns: 1fr;
    }

    .wfm-pro-preview-sticky {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .wfm-formations-grid,
    .wfm-style-selector,
    .wfm-colors-grid {
        grid-template-columns: 1fr;
    }

    .wfm-checkboxes-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Mettre à jour la valeur hexadécimale des couleurs
    $('input[type="color"]').on('change', function() {
        $(this).siblings('.color-value').val($(this).val().toUpperCase());
        updatePreview();
    });

    // Sélection de formation
    $('.wfm-formation-checkbox').on('change', function() {
        $(this).closest('.wfm-formation-card').toggleClass('selected', $(this).is(':checked'));
        updatePreview();
    });

    // Media uploader pour les logos
    var currentLogoInput;

    $(document).on('click', '.wfm-upload-logo', function(e) {
        e.preventDefault();
        currentLogoInput = $(this).siblings('.wfm-logo-id');
        var logoPreview = $(this).siblings('.wfm-logo-preview');
        var removeBtn = $(this).siblings('.wfm-remove-logo');

        var mediaUploader = wp.media({
            title: 'Choisir un logo',
            button: {
                text: 'Utiliser ce logo'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            currentLogoInput.val(attachment.id);
            logoPreview.html('<img src="' + attachment.url + '" alt="Logo">');

            if (removeBtn.length === 0) {
                $('<button type="button" class="wfm-remove-logo button">Retirer</button>').insertAfter(logoPreview.parent().find('.wfm-upload-logo'));
            }

            updatePreview();
        });

        mediaUploader.open();
    });

    $(document).on('click', '.wfm-remove-logo', function(e) {
        e.preventDefault();
        var logoInput = $(this).siblings('.wfm-logo-id');
        var logoPreview = $(this).siblings('.wfm-logo-preview');

        logoInput.val('');
        logoPreview.html('<span class="wfm-logo-placeholder">Aucun logo</span>');
        $(this).remove();

        updatePreview();
    });

    // Actualiser l'aperçu
    var previewTimeout;

    function updatePreview() {
        clearTimeout(previewTimeout);
        previewTimeout = setTimeout(loadPreview, 500);
    }

    function loadPreview() {
        var selectedFormations = $('.wfm-formation-checkbox:checked');

        if (selectedFormations.length === 0) {
            $('#wfm-preview-container').html('<div class="wfm-preview-loading"><div class="wfm-spinner"></div><p>Sélectionnez au moins une formation pour voir l\'aperçu...</p></div>');
            return;
        }

        // Récupérer la première formation sélectionnée pour l'aperçu
        var firstFormationId = selectedFormations.first().val();

        $('#wfm-preview-container').html('<div class="wfm-preview-loading"><div class="wfm-spinner"></div><p>Chargement de l\'aperçu...</p></div>');

        // Appel AJAX pour récupérer les vraies données
        $.ajax({
            url: wfmAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'wfm_get_formation_data',
                nonce: wfmAjax.nonce,
                formation_id: firstFormationId
            },
            success: function(response) {
                if (response.success) {
                    renderPreview(response.data);
                } else {
                    $('#wfm-preview-container').html('<div class="wfm-preview-loading"><p>❌ Erreur: ' + response.data + '</p></div>');
                }
            },
            error: function() {
                $('#wfm-preview-container').html('<div class="wfm-preview-loading"><p>❌ Erreur de connexion</p></div>');
            }
        });
    }

    function renderPreview(formation) {
        var cardStyle = $('input[name="wfm_card_style"]:checked').val();
        var bgColor = $('input[name="wfm_bg_color"]').val();
        var textColor = $('input[name="wfm_text_color"]').val();
        var accentColor = $('input[name="wfm_accent_color"]').val();
        var showExcerpt = $('input[name="wfm_show_excerpt"]').is(':checked');
        var showFormateur = $('input[name="wfm_show_formateur"]').is(':checked');
        var showDuree = $('input[name="wfm_show_duree"]').is(':checked');
        var showPrix = $('input[name="wfm_show_prix"]').is(':checked');
        var showModules = $('input[name="wfm_show_modules_count"]').is(':checked');
        var ctaText = $('input[name="wfm_cta_text"]').val();
        var ctaStyle = $('input[name="wfm_cta_style"]:checked').val();
        var ctaBgColor = $('input[name="wfm_cta_bg_color"]').val();
        var ctaTextColor = $('input[name="wfm_cta_text_color"]').val();

        var html = '<div class="wfm-card-preview" style="background: transparent; padding: 0;">';
        html += '<div class="wfm-card wfm-card-' + cardStyle + '" style="background: ' + bgColor + '; color: ' + textColor + '; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">';

        // Header avec gradient Insufflé si style insuffle
        if (cardStyle === 'insuffle') {
            html += '<div class="wfm-card-header" style="background: linear-gradient(135deg, ' + accentColor + ' 0%, #E91E63 100%); padding: 20px; color: white;">';
            html += '<h3 style="margin: 0; font-size: 20px; color: white;">' + formation.title + '</h3>';
            html += '</div>';
        } else {
            html += '<div class="wfm-card-header" style="padding: 20px;">';
            html += '<h3 style="margin: 0; font-size: 20px; color: ' + accentColor + ';">' + formation.title + '</h3>';
            html += '</div>';
        }

        html += '<div class="wfm-card-body" style="padding: 20px;">';

        // Extrait
        if (showExcerpt && formation.excerpt) {
            html += '<p style="color: ' + textColor + '; margin: 0 0 15px 0; line-height: 1.6;">' + formation.excerpt + '</p>';
        }

        // Meta info
        html += '<div class="wfm-card-meta" style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 15px;">';

        if (showDuree && formation.duree) {
            html += '<span style="display: flex; align-items: center; gap: 5px; font-size: 14px;">⏱️ ' + formation.duree + '</span>';
        }

        if (showPrix && formation.prix) {
            html += '<span style="display: flex; align-items: center; gap: 5px; font-size: 14px;">💰 ' + formation.prix + '</span>';
        }

        if (showModules && formation.modules_count) {
            html += '<span style="display: flex; align-items: center; gap: 5px; font-size: 14px;">📚 ' + formation.modules_count + ' modules</span>';
        }

        html += '</div>';

        // Formateur
        if (showFormateur && formation.formateur) {
            html += '<div class="wfm-formateur" style="display: flex; align-items: center; gap: 10px; padding: 12px; background: rgba(0,0,0,0.02); border-radius: 8px; margin-bottom: 15px;">';
            if (formation.formateur.photo) {
                html += '<img src="' + formation.formateur.photo + '" alt="' + formation.formateur.nom + '" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">';
            }
            html += '<div><div style="font-weight: 600; font-size: 14px;">' + formation.formateur.nom + '</div>';
            if (formation.formateur.tagline) {
                html += '<div style="font-size: 12px; color: #666;">' + formation.formateur.tagline + '</div>';
            }
            html += '</div></div>';
        }

        // CTA
        var ctaStyles = '';
        if (ctaStyle === 'solid') {
            ctaStyles = 'background: ' + ctaBgColor + '; color: ' + ctaTextColor + '; border: 2px solid ' + ctaBgColor + ';';
        } else if (ctaStyle === 'outline') {
            ctaStyles = 'background: transparent; color: ' + ctaBgColor + '; border: 2px solid ' + ctaBgColor + ';';
        } else if (ctaStyle === 'gradient') {
            ctaStyles = 'background: linear-gradient(135deg, ' + ctaBgColor + ' 0%, #E91E63 100%); color: ' + ctaTextColor + '; border: none;';
        }

        html += '<a href="' + formation.url + '" class="wfm-cta" style="display: block; text-align: center; padding: 14px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; ' + ctaStyles + '">';
        html += ctaText;
        html += '</a>';

        html += '</div>'; // body
        html += '</div>'; // card
        html += '</div>'; // preview

        $('#wfm-preview-container').html(html);
    }

    // Déclencheurs de mise à jour
    $('input[type="checkbox"], input[type="radio"], input[type="text"], input[type="color"], select').on('change', updatePreview);

    // Bouton rafraîchir
    $('.wfm-refresh-preview').on('click', function() {
        loadPreview();
    });

    // Charger l'aperçu initial si une formation est sélectionnée
    if ($('.wfm-formation-checkbox:checked').length > 0) {
        setTimeout(loadPreview, 500);
    }
});
</script>
