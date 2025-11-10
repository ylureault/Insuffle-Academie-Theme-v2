<?php
/**
 * Template: Éditer un programme de formation
 */

if (!defined('ABSPATH')) exit;

// Sauvegarder si formulaire soumis
if (isset($_POST['pfm_save_programme']) && check_admin_referer('pfm_save_programme_' . $formation_id)) {
    // Sauvegarder les modules
    $modules_data = isset($_POST['pfm_modules']) ? $_POST['pfm_modules'] : array();
    $modules_clean = array();

    foreach ($modules_data as $module) {
        $modules_clean[] = array(
            'number' => sanitize_text_field($module['number'] ?? ''),
            'title' => sanitize_text_field($module['title'] ?? ''),
            'duree' => sanitize_text_field($module['duree'] ?? ''),
            'objectif' => wp_kses_post($module['objectif'] ?? ''),
            'content' => wp_kses_post($module['content'] ?? ''),
            'evaluation' => sanitize_text_field($module['evaluation'] ?? ''),
        );
    }

    update_post_meta($formation_id, '_pfm_modules', $modules_clean);

    // Sauvegarder les infos pratiques
    $infos_data = array(
        'methodes' => wp_kses_post($_POST['pfm_methodes'] ?? ''),
        'moyens' => wp_kses_post($_POST['pfm_moyens'] ?? ''),
        'evaluation' => wp_kses_post($_POST['pfm_evaluation'] ?? ''),
    );

    update_post_meta($formation_id, '_pfm_infos_pratiques', $infos_data);

    // Sauvegarder les objectifs pédagogiques
    $objectifs_data = array(
        'introduction' => wp_kses_post($_POST['pfm_objectifs_intro'] ?? ''),
        'objectifs' => wp_kses_post($_POST['pfm_objectifs_liste'] ?? ''),
        'preambule_titre' => sanitize_text_field($_POST['pfm_preambule_titre'] ?? ''),
        'preambule_contenu' => wp_kses_post($_POST['pfm_preambule_contenu'] ?? ''),
    );

    update_post_meta($formation_id, '_pfm_objectifs', $objectifs_data);

    // Sauvegarder les informations pratiques détaillées
    $informations_data = array(
        'tableau' => isset($_POST['pfm_info_tableau']) && is_array($_POST['pfm_info_tableau']) ? array_map(function($row) {
            return array(
                'element' => sanitize_text_field($row['element'] ?? ''),
                'detail' => sanitize_text_field($row['detail'] ?? ''),
            );
        }, $_POST['pfm_info_tableau']) : array(),
        'moyens_techniques' => wp_kses_post($_POST['pfm_moyens_techniques'] ?? ''),
        'encadrement' => wp_kses_post($_POST['pfm_encadrement'] ?? ''),
        'suivi_post' => wp_kses_post($_POST['pfm_suivi_post'] ?? ''),
    );

    update_post_meta($formation_id, '_pfm_informations', $informations_data);

    // Sauvegarder les bénéfices
    $benefices_data = isset($_POST['pfm_benefices']) && is_array($_POST['pfm_benefices']) ? array_map(function($benefice) {
        return array(
            'icone' => sanitize_text_field($benefice['icone'] ?? ''),
            'titre' => sanitize_text_field($benefice['titre'] ?? ''),
            'description' => wp_kses_post($benefice['description'] ?? ''),
        );
    }, $_POST['pfm_benefices']) : array();

    update_post_meta($formation_id, '_pfm_benefices', $benefices_data);

    // Sauvegarder les tarifs
    $tarifs_data = array(
        'intra' => sanitize_text_field($_POST['pfm_tarif_intra'] ?? ''),
        'inter' => sanitize_text_field($_POST['pfm_tarif_inter'] ?? ''),
        'notes' => wp_kses_post($_POST['pfm_tarif_notes'] ?? ''),
    );

    update_post_meta($formation_id, '_pfm_tarifs', $tarifs_data);

    echo '<div class="notice notice-success is-dismissible"><p><strong>' . __('Programme sauvegardé avec succès !', 'programme-formation') . '</strong></p></div>';

    // Recharger les données
    $modules = PFM_Modules_Manager::get_modules($formation_id);
    $infos = PFM_Modules_Manager::get_infos_pratiques($formation_id);
    $objectifs = get_post_meta($formation_id, '_pfm_objectifs', true);
    $informations = get_post_meta($formation_id, '_pfm_informations', true);
    $benefices = get_post_meta($formation_id, '_pfm_benefices', true);
    $tarifs = get_post_meta($formation_id, '_pfm_tarifs', true);
}

// Récupérer les objectifs si pas encore chargés
if (!isset($objectifs) || !is_array($objectifs)) {
    $objectifs = get_post_meta($formation_id, '_pfm_objectifs', true);
    if (empty($objectifs) || !is_array($objectifs)) {
        $objectifs = array(
            'introduction' => '',
            'objectifs' => '',
            'preambule_titre' => '',
            'preambule_contenu' => '',
        );
    }
}

// Récupérer les informations si pas encore chargées
if (!isset($informations) || !is_array($informations)) {
    $informations = get_post_meta($formation_id, '_pfm_informations', true);
    if (empty($informations) || !is_array($informations)) {
        $informations = array(
            'tableau' => array(),
            'moyens_techniques' => '',
            'encadrement' => '',
            'suivi_post' => '',
        );
    }
}

// Récupérer les bénéfices si pas encore chargés
if (!isset($benefices) || !is_array($benefices)) {
    $benefices = get_post_meta($formation_id, '_pfm_benefices', true);
    if (empty($benefices) || !is_array($benefices)) {
        $benefices = array();
    }
}

// Récupérer les tarifs si pas encore chargés
if (!isset($tarifs) || !is_array($tarifs)) {
    $tarifs = get_post_meta($formation_id, '_pfm_tarifs', true);
    if (empty($tarifs) || !is_array($tarifs)) {
        $tarifs = array(
            'intra' => '',
            'inter' => '',
            'notes' => '',
        );
    }
}
?>

<div class="wrap pfm-edit-wrap">
    <h1 class="wp-heading-inline">
        <span class="dashicons dashicons-edit"></span>
        <?php printf(__('Éditer le programme : %s', 'programme-formation'), esc_html($formation->post_title)); ?>
    </h1>

    <a href="<?php echo admin_url('admin.php?page=programme-formation'); ?>" class="page-title-action">
        <span class="dashicons dashicons-arrow-left-alt2"></span>
        <?php _e('Retour à la liste', 'programme-formation'); ?>
    </a>

    <hr class="wp-header-end">

    <form method="post" action="" class="pfm-edit-form">
        <?php wp_nonce_field('pfm_save_programme_' . $formation_id); ?>

        <!-- Onglets -->
        <h2 class="nav-tab-wrapper">
            <a href="#objectifs" class="nav-tab nav-tab-active">
                <span class="dashicons dashicons-welcome-learn-more"></span>
                <?php _e('Objectifs pédagogiques', 'programme-formation'); ?>
            </a>
            <a href="#modules" class="nav-tab">
                <span class="dashicons dashicons-list-view"></span>
                <?php _e('Modules du programme', 'programme-formation'); ?>
            </a>
            <a href="#informations" class="nav-tab">
                <span class="dashicons dashicons-clipboard"></span>
                <?php _e('Informations', 'programme-formation'); ?>
            </a>
            <a href="#benefices" class="nav-tab">
                <span class="dashicons dashicons-star-filled"></span>
                <?php _e('Bénéfices', 'programme-formation'); ?>
            </a>
            <a href="#tarifs" class="nav-tab">
                <span class="dashicons dashicons-money-alt"></span>
                <?php _e('Tarifs', 'programme-formation'); ?>
            </a>
            <a href="#infos" class="nav-tab">
                <span class="dashicons dashicons-info"></span>
                <?php _e('Méthodes pédagogiques', 'programme-formation'); ?>
            </a>
        </h2>

        <!-- Contenu des onglets -->
        <div class="pfm-tab-content">
            <!-- Tab: Objectifs pédagogiques -->
            <div id="objectifs" class="pfm-tab-panel active">
                <div class="pfm-objectifs-container">
                    <div class="pfm-info-group">
                        <label>
                            <strong>📝 Introduction / Sous-titre</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_objectifs_intro" rows="3" class="large-text" placeholder="Ex: À l'issue de cette formation en facilitation et intelligence collective, chaque participant sera capable de :"><?php echo esc_textarea($objectifs['introduction']); ?></textarea>
                        <p class="description">Texte d'introduction qui apparaîtra avant la liste des objectifs</p>
                    </div>

                    <div class="pfm-info-group">
                        <label>
                            <strong>🎯 Liste des objectifs pédagogiques</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_objectifs_liste" rows="15" class="large-text code" placeholder="Comprendre les fondements de la facilitation et de l'intelligence collective en entreprise
Adopter une posture juste et consciente : neutralité, écoute, clarté, présence
Concevoir un processus collectif adapté à un objectif ou un enjeu réel
Créer un cadre sécurisant et mobilisateur favorisant la confiance et la co-responsabilité"><?php echo esc_textarea($objectifs['objectifs']); ?></textarea>
                        <p class="description">
                            <strong>Un objectif par ligne.</strong> Chaque ligne sera affichée avec une coche ✓ dans un encadré blanc.<br>
                            Vous pouvez utiliser <strong>**texte**</strong> pour mettre en gras (sera converti automatiquement).
                        </p>
                    </div>

                    <hr style="margin: 40px 0; border: 0; border-top: 2px solid #ddd;">

                    <h3 style="color: var(--pfm-primary); margin-bottom: 20px;">📚 Préambule</h3>
                    <p style="margin-bottom: 20px; color: #666;">Section qui apparaîtra entre les objectifs et les modules (encadré coloré)</p>

                    <div class="pfm-info-group">
                        <label>
                            <strong>Titre du préambule</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <input type="text" name="pfm_preambule_titre" class="regular-text" placeholder="Ex: 📚 Préambule – Poser les bases" value="<?php echo esc_attr($objectifs['preambule_titre'] ?? ''); ?>">
                    </div>

                    <div class="pfm-info-group">
                        <label>
                            <strong>Contenu du préambule</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_preambule_contenu" rows="10" class="large-text code" placeholder="Qu'est-ce que la facilitation et l'intelligence collective ?
Histoire, principes et différences avec l'animation, la formation, le coaching ou le management
Pourquoi faciliter ? Les enjeux contemporains du collectif
Le rôle du facilitateur dans la transformation des organisations"><?php echo esc_textarea($objectifs['preambule_contenu'] ?? ''); ?></textarea>
                        <p class="description">
                            Un élément par ligne. Sera affiché comme une liste à puces dans un encadré coloré.
                        </p>
                    </div>

                    <div class="pfm-help">
                        <p><strong>💡 Astuce :</strong></p>
                        <ul>
                            <li>Ordre d'affichage : <strong>Objectifs → Préambule → Modules</strong></li>
                            <li>Les objectifs auront un graphisme identique au template fourni</li>
                            <li>Laissez vide pour ne pas afficher ces sections</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab: Modules -->
            <div id="modules" class="pfm-tab-panel">
                <div class="pfm-modules-container">
                    <div id="pfm-modules-list">
                        <?php if (!empty($modules)): ?>
                            <?php foreach ($modules as $index => $module): ?>
                                <?php include PFM_PLUGIN_DIR . 'templates/module-row.php'; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="pfm-add-module-wrap">
                        <button type="button" class="button button-primary button-large pfm-add-module">
                            <span class="dashicons dashicons-plus-alt"></span>
                            <?php _e('Ajouter un module', 'programme-formation'); ?>
                        </button>
                    </div>

                    <div class="pfm-help">
                        <p><strong>💡 Astuce :</strong></p>
                        <ul>
                            <li>Glissez-déposez pour réorganiser les modules</li>
                            <li>Chaque ligne du contenu aura automatiquement une coche ✓</li>
                            <li>Tous les champs sont optionnels</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab: Informations -->
            <div id="informations" class="pfm-tab-panel">
                <div class="pfm-informations-container">
                    <h3>📋 Tableau des informations pratiques</h3>
                    <p class="description">Remplissez le tableau avec les éléments et leurs détails (optionnel)</p>

                    <div id="pfm-info-tableau-list">
                        <?php if (!empty($informations['tableau'])): ?>
                            <?php foreach ($informations['tableau'] as $index => $row): ?>
                                <div class="pfm-info-row">
                                    <input type="text" name="pfm_info_tableau[<?php echo $index; ?>][element]" class="regular-text" placeholder="Ex: Durée totale" value="<?php echo esc_attr($row['element']); ?>">
                                    <input type="text" name="pfm_info_tableau[<?php echo $index; ?>][detail]" class="large-text" placeholder="Ex: 21 heures (3 jours consécutifs)" value="<?php echo esc_attr($row['detail']); ?>">
                                    <button type="button" class="button pfm-remove-row">Supprimer</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="button button-secondary pfm-add-info-row">
                        <span class="dashicons dashicons-plus-alt"></span>
                        Ajouter une ligne
                    </button>

                    <hr style="margin: 40px 0;">

                    <h3>🏢 Moyens techniques</h3>
                    <textarea name="pfm_moyens_techniques" rows="8" class="large-text" placeholder="Un élément par ligne (sera affiché en liste à puces dans une card)"><?php echo esc_textarea($informations['moyens_techniques']); ?></textarea>

                    <h3>👨‍🏫 Encadrement</h3>
                    <textarea name="pfm_encadrement" rows="5" class="large-text" placeholder="Un élément par ligne"><?php echo esc_textarea($informations['encadrement']); ?></textarea>

                    <h3>📚 Suivi post-formation</h3>
                    <textarea name="pfm_suivi_post" rows="5" class="large-text" placeholder="Un élément par ligne"><?php echo esc_textarea($informations['suivi_post']); ?></textarea>
                </div>
            </div>

            <!-- Tab: Bénéfices -->
            <div id="benefices" class="pfm-tab-panel">
                <div class="pfm-benefices-container">
                    <h3>✨ Bénéfices de la formation</h3>
                    <p class="description">Ajoutez les bénéfices sous forme de cards (icône, titre, description)</p>

                    <div id="pfm-benefices-list">
                        <?php if (!empty($benefices)): ?>
                            <?php foreach ($benefices as $index => $benefice): ?>
                                <div class="pfm-benefice-card">
                                    <input type="text" name="pfm_benefices[<?php echo $index; ?>][icone]" class="small-text" placeholder="🧘" value="<?php echo esc_attr($benefice['icone']); ?>" style="width: 60px;">
                                    <input type="text" name="pfm_benefices[<?php echo $index; ?>][titre]" class="regular-text" placeholder="Ex: Posture de facilitateur" value="<?php echo esc_attr($benefice['titre']); ?>">
                                    <textarea name="pfm_benefices[<?php echo $index; ?>][description]" rows="3" class="large-text" placeholder="Description du bénéfice..."><?php echo esc_textarea($benefice['description']); ?></textarea>
                                    <button type="button" class="button pfm-remove-benefice">Supprimer</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="button button-primary button-large pfm-add-benefice">
                        <span class="dashicons dashicons-plus-alt"></span>
                        Ajouter un bénéfice
                    </button>
                </div>
            </div>

            <!-- Tab: Tarifs -->
            <div id="tarifs" class="pfm-tab-panel">
                <div class="pfm-tarifs-container">
                    <h3>💰 Tarifs de la formation</h3>
                    <p class="description">Indiquez les tarifs intra-entreprise et inter-entreprises (optionnel)</p>

                    <div class="pfm-info-group">
                        <label>
                            <strong>Tarif Intra-entreprise</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <input type="text" name="pfm_tarif_intra" class="regular-text" placeholder="Ex: 4 500€ HT" value="<?php echo esc_attr($tarifs['intra'] ?? ''); ?>">
                        <p class="description">Format libre. Ex: "4 500€ HT pour un groupe de 6 à 12 personnes"</p>
                    </div>

                    <div class="pfm-info-group">
                        <label>
                            <strong>Tarif Inter-entreprises</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <input type="text" name="pfm_tarif_inter" class="regular-text" placeholder="Ex: 1 500€ HT par personne" value="<?php echo esc_attr($tarifs['inter'] ?? ''); ?>">
                        <p class="description">Format libre. Ex: "1 500€ HT par participant"</p>
                    </div>

                    <div class="pfm-info-group">
                        <label>
                            <strong>Informations complémentaires sur les tarifs</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_tarif_notes" rows="5" class="large-text" placeholder="Ex: Financement possible par OPCO..."><?php echo esc_textarea($tarifs['notes'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Tab: Méthodes pédagogiques (ancien "Infos pratiques") -->
            <div id="infos" class="pfm-tab-panel">
                <div class="pfm-infos-container">
                    <div class="pfm-info-group">
                        <label>
                            <strong>🎯 Méthodes pédagogiques</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_methodes" rows="5" class="large-text" placeholder="Ex: Alternance d'apports théoriques et d'exercices pratiques..."><?php echo esc_textarea($infos['methodes']); ?></textarea>
                    </div>

                    <div class="pfm-info-group">
                        <label>
                            <strong>🛠️ Moyens techniques</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_moyens" rows="7" class="large-text" placeholder="Ex: Supports visuels, Paperboards, Feutres..."><?php echo esc_textarea($infos['moyens']); ?></textarea>
                        <p class="description">Vous pouvez utiliser du HTML (listes, etc.)</p>
                    </div>

                    <div class="pfm-info-group">
                        <label>
                            <strong>✅ Modalités d'évaluation</strong>
                            <span class="pfm-optional">(optionnel)</span>
                        </label>
                        <textarea name="pfm_evaluation" rows="5" class="large-text" placeholder="Ex: Évaluation continue au fil des modules..."><?php echo esc_textarea($infos['evaluation']); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons de sauvegarde -->
        <div class="pfm-submit-wrap">
            <button type="submit" name="pfm_save_programme" class="button button-primary button-hero">
                <span class="dashicons dashicons-yes"></span>
                <?php _e('Sauvegarder le programme', 'programme-formation'); ?>
            </button>

            <a href="<?php echo get_permalink($formation_id); ?>" class="button button-secondary button-hero" target="_blank">
                <span class="dashicons dashicons-visibility"></span>
                <?php _e('Voir la page', 'programme-formation'); ?>
            </a>
        </div>
    </form>
</div>

<!-- Template pour nouveau module -->
<script type="text/template" id="pfm-module-template">
    <?php
    $index = '{{INDEX}}';
    $module = array(
        'number' => '',
        'title' => '',
        'duree' => '',
        'objectif' => '',
        'content' => '',
        'evaluation' => '',
    );
    include PFM_PLUGIN_DIR . 'templates/module-row.php';
    ?>
</script>

<style>
.pfm-edit-wrap {
    margin: 20px 20px 0 0;
}

.pfm-edit-wrap h1 {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pfm-edit-wrap h1 .dashicons {
    font-size: 32px;
    width: 32px;
    height: 32px;
    color: #8E2183;
}

.pfm-tab-content {
    background: white;
    padding: 30px;
    margin-top: -1px;
    border: 1px solid #c3c4c7;
    border-top: none;
}

.pfm-tab-panel {
    display: none;
}

.pfm-tab-panel.active {
    display: block;
}

.pfm-modules-container,
.pfm-infos-container {
    max-width: 1200px;
}

.pfm-add-module-wrap {
    text-align: center;
    margin: 30px 0;
}

.pfm-help {
    background: #e7f3ff;
    border-left: 4px solid #0073aa;
    padding: 15px 20px;
    margin-top: 30px;
}

.pfm-help ul {
    margin: 10px 0 0 20px;
}

.pfm-info-group {
    margin-bottom: 30px;
}

.pfm-info-group label {
    display: block;
    margin-bottom: 8px;
}

.pfm-optional {
    font-weight: normal;
    font-style: italic;
    color: #666;
    font-size: 13px;
}

.pfm-submit-wrap {
    background: #f0f0f1;
    padding: 20px;
    margin-top: 30px;
    border-top: 1px solid #c3c4c7;
    text-align: center;
}

.pfm-submit-wrap .button {
    margin: 0 10px;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Gestion des onglets
    $('.nav-tab').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');

        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        $('.pfm-tab-panel').removeClass('active');
        $(target).addClass('active');
    });
});
</script>
