<?php
/**
 * Custom Post Types et Meta Boxes pour Insuffle Académie
 * Gestion des formations avec tous les champs Qualiopi
 */

if (!defined('ABSPATH')) exit;

// ========================================
// 1. ENREGISTREMENT DU CUSTOM POST TYPE
// ========================================

function insuffle_register_formation_post_type() {
    $labels = array(
        'name'                  => 'Formations',
        'singular_name'         => 'Formation',
        'menu_name'             => 'Formations',
        'add_new'               => 'Ajouter une formation',
        'add_new_item'          => 'Ajouter une nouvelle formation',
        'edit_item'             => 'Modifier la formation',
        'new_item'              => 'Nouvelle formation',
        'view_item'             => 'Voir la formation',
        'search_items'          => 'Rechercher une formation',
        'not_found'             => 'Aucune formation trouvée',
        'not_found_in_trash'    => 'Aucune formation dans la corbeille',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'formation-detail'), // Changé pour éviter conflit
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
        'show_in_rest'          => true, // Support Gutenberg
    );

    register_post_type('formation', $args);
}
add_action('init', 'insuffle_register_formation_post_type');

// ========================================
// 2. AJOUT DES META BOXES
// ========================================

function insuffle_add_formation_meta_boxes() {
    // Informations générales
    add_meta_box(
        'formation_general',
        'Informations générales',
        'insuffle_formation_general_callback',
        'formation',
        'normal',
        'high'
    );
    
    // Public et prérequis
    add_meta_box(
        'formation_public',
        'Public visé et prérequis',
        'insuffle_formation_public_callback',
        'formation',
        'normal',
        'high'
    );
    
    // Objectifs et compétences
    add_meta_box(
        'formation_objectifs',
        'Objectifs et compétences',
        'insuffle_formation_objectifs_callback',
        'formation',
        'normal',
        'high'
    );
    
    // Programme
    add_meta_box(
        'formation_programme',
        'Programme détaillé',
        'insuffle_formation_programme_callback',
        'formation',
        'normal',
        'default'
    );
    
    // Pédagogie
    add_meta_box(
        'formation_pedagogie',
        'Méthodes pédagogiques',
        'insuffle_formation_pedagogie_callback',
        'formation',
        'normal',
        'default'
    );
    
    // Évaluation et suivi
    add_meta_box(
        'formation_evaluation',
        'Évaluation et suivi',
        'insuffle_formation_evaluation_callback',
        'formation',
        'normal',
        'default'
    );
    
    // Tarifs
    add_meta_box(
        'formation_tarifs',
        'Tarifs et financement',
        'insuffle_formation_tarifs_callback',
        'formation',
        'side',
        'high'
    );
    
    // Modalités pratiques
    add_meta_box(
        'formation_modalites',
        'Modalités pratiques',
        'insuffle_formation_modalites_callback',
        'formation',
        'side',
        'default'
    );
    
    // Indicateurs
    add_meta_box(
        'formation_indicateurs',
        'Indicateurs de performance',
        'insuffle_formation_indicateurs_callback',
        'formation',
        'side',
        'default'
    );
    
    // Médias et documents
    add_meta_box(
        'formation_medias',
        'Galerie photos et documents',
        'insuffle_formation_medias_callback',
        'formation',
        'normal',
        'default'
    );
    
    // Boutons personnalisés
    add_meta_box(
        'formation_boutons',
        'Boutons et téléchargements',
        'insuffle_formation_boutons_callback',
        'formation',
        'normal',
        'default'
    );
    
    // Formulaire inscription
    add_meta_box(
        'formation_formulaire',
        'Formulaire inscription prochaines dates',
        'insuffle_formation_formulaire_callback',
        'formation',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'insuffle_add_formation_meta_boxes');

// ========================================
// 3. CALLBACKS DES META BOXES
// ========================================

// Informations générales
function insuffle_formation_general_callback($post) {
    wp_nonce_field('insuffle_formation_meta', 'insuffle_formation_nonce');
    
    $reference = get_post_meta($post->ID, '_formation_reference', true);
    $duree_jours = get_post_meta($post->ID, '_formation_duree_jours', true);
    $duree_heures = get_post_meta($post->ID, '_formation_duree_heures', true);
    $modalite = get_post_meta($post->ID, '_formation_modalite', true);
    $lieu = get_post_meta($post->ID, '_formation_lieu', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_reference">Référence</label></th>
            <td><input type="text" id="formation_reference" name="formation_reference" value="<?php echo esc_attr($reference); ?>" class="regular-text" placeholder="Ex: FORM-001"></td>
        </tr>
        <tr>
            <th><label for="formation_duree_jours">Durée (jours)</label></th>
            <td><input type="number" id="formation_duree_jours" name="formation_duree_jours" value="<?php echo esc_attr($duree_jours); ?>" min="0" step="0.5" placeholder="Ex: 3"></td>
        </tr>
        <tr>
            <th><label for="formation_duree_heures">Durée (heures)</label></th>
            <td><input type="number" id="formation_duree_heures" name="formation_duree_heures" value="<?php echo esc_attr($duree_heures); ?>" min="0" step="0.5" placeholder="Ex: 21"></td>
        </tr>
        <tr>
            <th><label for="formation_modalite">Modalité</label></th>
            <td>
                <select id="formation_modalite" name="formation_modalite">
                    <option value="">-- Sélectionner --</option>
                    <option value="Présentiel" <?php selected($modalite, 'Présentiel'); ?>>Présentiel</option>
                    <option value="Distanciel" <?php selected($modalite, 'Distanciel'); ?>>Distanciel</option>
                    <option value="Présentiel ou distanciel" <?php selected($modalite, 'Présentiel ou distanciel'); ?>>Présentiel ou distanciel</option>
                    <option value="Hybride" <?php selected($modalite, 'Hybride'); ?>>Hybride</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="formation_lieu">Lieu</label></th>
            <td><input type="text" id="formation_lieu" name="formation_lieu" value="<?php echo esc_attr($lieu); ?>" class="regular-text" placeholder="Ex: Deauville"></td>
        </tr>
    </table>
    <?php
}

// Médias et documents
function insuffle_formation_medias_callback($post) {
    $galerie = get_post_meta($post->ID, '_formation_galerie', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_galerie">Galerie photos</label></th>
            <td>
                <div class="formation-gallery-container">
                    <input type="hidden" id="formation_galerie" name="formation_galerie" value="<?php echo esc_attr($galerie); ?>">
                    <div id="gallery-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
                        <?php
                        if ($galerie) {
                            $gallery_ids = explode(',', $galerie);
                            foreach ($gallery_ids as $img_id) {
                                $img_url = wp_get_attachment_image_src($img_id, 'thumbnail');
                                if ($img_url) {
                                    echo '<div class="gallery-item" style="position: relative; width: 100px; height: 100px;">';
                                    echo '<img src="' . esc_url($img_url[0]) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">';
                                    echo '<button type="button" class="remove-gallery-image" data-id="' . esc_attr($img_id) . '" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <button type="button" class="button" id="upload_gallery_button">Ajouter des photos</button>
                </div>
                <p class="description">Sélectionnez plusieurs photos pour créer une galerie</p>
            </td>
        </tr>
    </table>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#upload_gallery_button').click(function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Sélectionner des photos',
                button: { text: 'Ajouter à la galerie' },
                multiple: true
            });
            
            mediaUploader.on('select', function() {
                var selection = mediaUploader.state().get('selection');
                var ids = $('#formation_galerie').val().split(',').filter(function(id) { return id; });
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    
                    $('#gallery-preview').append(
                        '<div class="gallery-item" style="position: relative; width: 100px; height: 100px;">' +
                        '<img src="' + attachment.sizes.thumbnail.url + '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">' +
                        '<button type="button" class="remove-gallery-image" data-id="' + attachment.id + '" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>' +
                        '</div>'
                    );
                });
                
                $('#formation_galerie').val(ids.join(','));
            });
            
            mediaUploader.open();
        });
        
        $(document).on('click', '.remove-gallery-image', function() {
            var idToRemove = $(this).data('id');
            var ids = $('#formation_galerie').val().split(',').filter(function(id) { 
                return id && id != idToRemove; 
            });
            $('#formation_galerie').val(ids.join(','));
            $(this).closest('.gallery-item').remove();
        });
    });
    </script>
    <?php
}

// Boutons personnalisés
function insuffle_formation_boutons_callback($post) {
    $bouton1_texte = get_post_meta($post->ID, '_formation_bouton1_texte', true);
    $bouton1_fichier = get_post_meta($post->ID, '_formation_bouton1_fichier', true);
    $bouton2_texte = get_post_meta($post->ID, '_formation_bouton2_texte', true);
    $bouton2_fichier = get_post_meta($post->ID, '_formation_bouton2_fichier', true);
    $bouton3_texte = get_post_meta($post->ID, '_formation_bouton3_texte', true);
    $bouton3_fichier = get_post_meta($post->ID, '_formation_bouton3_fichier', true);
    ?>
    <table class="form-table">
        <!-- Bouton 1 -->
        <tr>
            <th colspan="2"><h3 style="margin: 0;">Bouton 1</h3></th>
        </tr>
        <tr>
            <th><label for="formation_bouton1_texte">Texte du bouton</label></th>
            <td><input type="text" id="formation_bouton1_texte" name="formation_bouton1_texte" value="<?php echo esc_attr($bouton1_texte); ?>" class="regular-text" placeholder="Ex: Télécharger la plaquette"></td>
        </tr>
        <tr>
            <th><label for="formation_bouton1_fichier">Fichier</label></th>
            <td>
                <input type="hidden" id="formation_bouton1_fichier" name="formation_bouton1_fichier" value="<?php echo esc_attr($bouton1_fichier); ?>">
                <button type="button" class="button upload-file-button" data-target="formation_bouton1_fichier">Sélectionner un fichier</button>
                <span class="file-name-display"><?php 
                    if ($bouton1_fichier) {
                        echo esc_html(basename(get_attached_file($bouton1_fichier)));
                    }
                ?></span>
            </td>
        </tr>
        
        <!-- Bouton 2 -->
        <tr>
            <th colspan="2"><h3 style="margin: 20px 0 0 0;">Bouton 2</h3></th>
        </tr>
        <tr>
            <th><label for="formation_bouton2_texte">Texte du bouton</label></th>
            <td><input type="text" id="formation_bouton2_texte" name="formation_bouton2_texte" value="<?php echo esc_attr($bouton2_texte); ?>" class="regular-text" placeholder="Ex: Télécharger le programme"></td>
        </tr>
        <tr>
            <th><label for="formation_bouton2_fichier">Fichier</label></th>
            <td>
                <input type="hidden" id="formation_bouton2_fichier" name="formation_bouton2_fichier" value="<?php echo esc_attr($bouton2_fichier); ?>">
                <button type="button" class="button upload-file-button" data-target="formation_bouton2_fichier">Sélectionner un fichier</button>
                <span class="file-name-display"><?php 
                    if ($bouton2_fichier) {
                        echo esc_html(basename(get_attached_file($bouton2_fichier)));
                    }
                ?></span>
            </td>
        </tr>
        
        <!-- Bouton 3 -->
        <tr>
            <th colspan="2"><h3 style="margin: 20px 0 0 0;">Bouton 3</h3></th>
        </tr>
        <tr>
            <th><label for="formation_bouton3_texte">Texte du bouton</label></th>
            <td><input type="text" id="formation_bouton3_texte" name="formation_bouton3_texte" value="<?php echo esc_attr($bouton3_texte); ?>" class="regular-text" placeholder="Ex: Consulter les CGV"></td>
        </tr>
        <tr>
            <th><label for="formation_bouton3_fichier">Fichier</label></th>
            <td>
                <input type="hidden" id="formation_bouton3_fichier" name="formation_bouton3_fichier" value="<?php echo esc_attr($bouton3_fichier); ?>">
                <button type="button" class="button upload-file-button" data-target="formation_bouton3_fichier">Sélectionner un fichier</button>
                <span class="file-name-display"><?php 
                    if ($bouton3_fichier) {
                        echo esc_html(basename(get_attached_file($bouton3_fichier)));
                    }
                ?></span>
            </td>
        </tr>
    </table>
    
    <script>
    jQuery(document).ready(function($) {
        $('.upload-file-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var targetInput = button.data('target');
            
            var fileUploader = wp.media({
                title: 'Sélectionner un fichier',
                button: { text: 'Sélectionner' },
                multiple: false
            });
            
            fileUploader.on('select', function() {
                var attachment = fileUploader.state().get('selection').first().toJSON();
                $('#' + targetInput).val(attachment.id);
                button.next('.file-name-display').text(attachment.filename);
            });
            
            fileUploader.open();
        });
    });
    </script>
    <?php
}

// Formulaire inscription
function insuffle_formation_formulaire_callback($post) {
    $formulaire_code = get_post_meta($post->ID, '_formation_formulaire_code', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_formulaire_code">Code du formulaire</label></th>
            <td>
                <textarea id="formation_formulaire_code" name="formation_formulaire_code" rows="8" style="width: 100%; font-family: monospace; font-size: 12px;"><?php echo esc_textarea($formulaire_code); ?></textarea>
                <p class="description">Collez ici le code iframe de votre formulaire Tally ou autre service</p>
            </td>
        </tr>
    </table>
    <?php
}

// Public et prérequis
function insuffle_formation_public_callback($post) {
    $public_vise = get_post_meta($post->ID, '_formation_public_vise', true);
    $prerequis = get_post_meta($post->ID, '_formation_prerequis', true);
    $niveau_requis = get_post_meta($post->ID, '_formation_niveau_requis', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_public_vise">Public visé</label></th>
            <td><textarea id="formation_public_vise" name="formation_public_vise" rows="4" class="large-text"><?php echo esc_textarea($public_vise); ?></textarea>
            <p class="description">Décrivez les profils concernés par cette formation</p></td>
        </tr>
        <tr>
            <th><label for="formation_prerequis">Prérequis</label></th>
            <td><textarea id="formation_prerequis" name="formation_prerequis" rows="3" class="large-text"><?php echo esc_textarea($prerequis); ?></textarea>
            <p class="description">Compétences ou connaissances nécessaires (ou "Aucun prérequis")</p></td>
        </tr>
        <tr>
            <th><label for="formation_niveau_requis">Niveau requis</label></th>
            <td>
                <select id="formation_niveau_requis" name="formation_niveau_requis">
                    <option value="">-- Sélectionner --</option>
                    <option value="Débutant" <?php selected($niveau_requis, 'Débutant'); ?>>Débutant</option>
                    <option value="Intermédiaire" <?php selected($niveau_requis, 'Intermédiaire'); ?>>Intermédiaire</option>
                    <option value="Avancé" <?php selected($niveau_requis, 'Avancé'); ?>>Avancé</option>
                    <option value="Tous niveaux" <?php selected($niveau_requis, 'Tous niveaux'); ?>>Tous niveaux</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Objectifs et compétences
function insuffle_formation_objectifs_callback($post) {
    $objectifs = get_post_meta($post->ID, '_formation_objectifs', true);
    $competences = get_post_meta($post->ID, '_formation_competences', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_objectifs">Objectifs pédagogiques</label></th>
            <td><textarea id="formation_objectifs" name="formation_objectifs" rows="8" class="large-text"><?php echo esc_textarea($objectifs); ?></textarea>
            <p class="description">Un objectif par ligne. Ex: "Maîtriser les techniques de facilitation"</p></td>
        </tr>
        <tr>
            <th><label for="formation_competences">Compétences visées</label></th>
            <td><textarea id="formation_competences" name="formation_competences" rows="6" class="large-text"><?php echo esc_textarea($competences); ?></textarea>
            <p class="description">Décrivez les compétences acquises à l'issue de la formation</p></td>
        </tr>
    </table>
    <?php
}

// Programme détaillé
function insuffle_formation_programme_callback($post) {
    $programme = get_post_meta($post->ID, '_formation_programme', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_programme">Programme complet</label></th>
            <td><textarea id="formation_programme" name="formation_programme" rows="15" class="large-text"><?php echo esc_textarea($programme); ?></textarea>
            <p class="description">Détaillez le programme jour par jour ou module par module</p></td>
        </tr>
    </table>
    <?php
}

// Méthodes pédagogiques
function insuffle_formation_pedagogie_callback($post) {
    $methodes = get_post_meta($post->ID, '_formation_methodes', true);
    $moyens_techniques = get_post_meta($post->ID, '_formation_moyens_techniques', true);
    $encadrement = get_post_meta($post->ID, '_formation_encadrement', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_methodes">Méthodes pédagogiques</label></th>
            <td><textarea id="formation_methodes" name="formation_methodes" rows="5" class="large-text"><?php echo esc_textarea($methodes); ?></textarea>
            <p class="description">Ex: Ateliers pratiques, études de cas, mises en situation...</p></td>
        </tr>
        <tr>
            <th><label for="formation_moyens_techniques">Moyens techniques</label></th>
            <td><textarea id="formation_moyens_techniques" name="formation_moyens_techniques" rows="4" class="large-text"><?php echo esc_textarea($moyens_techniques); ?></textarea>
            <p class="description">Matériel, outils, supports fournis</p></td>
        </tr>
        <tr>
            <th><label for="formation_encadrement">Encadrement</label></th>
            <td><textarea id="formation_encadrement" name="formation_encadrement" rows="4" class="large-text"><?php echo esc_textarea($encadrement); ?></textarea>
            <p class="description">Qualifications des formateurs</p></td>
        </tr>
    </table>
    <?php
}

// Évaluation et suivi
function insuffle_formation_evaluation_callback($post) {
    $suivi = get_post_meta($post->ID, '_formation_suivi', true);
    $evaluation = get_post_meta($post->ID, '_formation_evaluation', true);
    $sanction = get_post_meta($post->ID, '_formation_sanction', true);
    $accessibilite = get_post_meta($post->ID, '_formation_accessibilite', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_suivi">Modalités de suivi</label></th>
            <td><textarea id="formation_suivi" name="formation_suivi" rows="3" class="large-text"><?php echo esc_textarea($suivi); ?></textarea>
            <p class="description">Ex: Feuilles d'émargement, attestations de présence</p></td>
        </tr>
        <tr>
            <th><label for="formation_evaluation">Modalités d'évaluation</label></th>
            <td><textarea id="formation_evaluation" name="formation_evaluation" rows="3" class="large-text"><?php echo esc_textarea($evaluation); ?></textarea>
            <p class="description">Comment les acquis sont évalués</p></td>
        </tr>
        <tr>
            <th><label for="formation_sanction">Sanction de la formation</label></th>
            <td><textarea id="formation_sanction" name="formation_sanction" rows="2" class="large-text"><?php echo esc_textarea($sanction); ?></textarea>
            <p class="description">Ex: Certificat de réalisation, Attestation de formation</p></td>
        </tr>
        <tr>
            <th><label for="formation_accessibilite">Accessibilité PMR</label></th>
            <td><textarea id="formation_accessibilite" name="formation_accessibilite" rows="3" class="large-text"><?php echo esc_textarea($accessibilite); ?></textarea>
            <p class="description">Accessibilité aux personnes en situation de handicap</p></td>
        </tr>
    </table>
    <?php
}

// Tarifs
function insuffle_formation_tarifs_callback($post) {
    $tarif_inter = get_post_meta($post->ID, '_formation_tarif_inter', true);
    $tarif_intra = get_post_meta($post->ID, '_formation_tarif_intra', true);
    $tarif_individuel = get_post_meta($post->ID, '_formation_tarif_individuel', true);
    $financement = get_post_meta($post->ID, '_formation_financement', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_tarif_inter">Tarif Inter (€ HT)</label></th>
            <td><input type="number" id="formation_tarif_inter" name="formation_tarif_inter" value="<?php echo esc_attr($tarif_inter); ?>" min="0" step="0.01" placeholder="1500"></td>
        </tr>
        <tr>
            <th><label for="formation_tarif_intra">Tarif Intra (€ HT)</label></th>
            <td><input type="number" id="formation_tarif_intra" name="formation_tarif_intra" value="<?php echo esc_attr($tarif_intra); ?>" min="0" step="0.01" placeholder="3500"></td>
        </tr>
        <tr>
            <th><label for="formation_tarif_individuel">Tarif Individuel (€ HT)</label></th>
            <td><input type="number" id="formation_tarif_individuel" name="formation_tarif_individuel" value="<?php echo esc_attr($tarif_individuel); ?>" min="0" step="0.01" placeholder="2000"></td>
        </tr>
        <tr>
            <th><label for="formation_financement">Financement</label></th>
            <td><textarea id="formation_financement" name="formation_financement" rows="3" style="width: 100%;"><?php echo esc_textarea($financement); ?></textarea>
            <p class="description">Ex: OPCO, CPF, Pôle Emploi...</p></td>
        </tr>
    </table>
    <?php
}

// Modalités pratiques
function insuffle_formation_modalites_callback($post) {
    $delai_acces = get_post_meta($post->ID, '_formation_delai_acces', true);
    $effectif_min = get_post_meta($post->ID, '_formation_effectif_min', true);
    $effectif_max = get_post_meta($post->ID, '_formation_effectif_max', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_delai_acces">Délai d'accès</label></th>
            <td><input type="text" id="formation_delai_acces" name="formation_delai_acces" value="<?php echo esc_attr($delai_acces); ?>" placeholder="Ex: 15 jours" style="width: 100%;"></td>
        </tr>
        <tr>
            <th><label for="formation_effectif_min">Effectif min</label></th>
            <td><input type="number" id="formation_effectif_min" name="formation_effectif_min" value="<?php echo esc_attr($effectif_min); ?>" min="1" placeholder="4"></td>
        </tr>
        <tr>
            <th><label for="formation_effectif_max">Effectif max</label></th>
            <td><input type="number" id="formation_effectif_max" name="formation_effectif_max" value="<?php echo esc_attr($effectif_max); ?>" min="1" placeholder="12"></td>
        </tr>
    </table>
    
    <h3 style="margin-top: 30px; margin-bottom: 15px;">Prochaines sessions</h3>
    <div id="sessions-container">
        <?php
        $sessions = get_post_meta($post->ID, '_formation_sessions_data', true);
        if (empty($sessions)) {
            $sessions = array(array()); // Une session vide par défaut
        }
        
        foreach ($sessions as $index => $session) :
            $date_debut = isset($session['date_debut']) ? $session['date_debut'] : '';
            $date_fin = isset($session['date_fin']) ? $session['date_fin'] : '';
            $lieu = isset($session['lieu']) ? $session['lieu'] : '';
            $places_dispo = isset($session['places_dispo']) ? $session['places_dispo'] : '';
            $statut = isset($session['statut']) ? $session['statut'] : 'disponible';
            $tarif_specifique = isset($session['tarif_specifique']) ? $session['tarif_specifique'] : '';
        ?>
        <div class="session-item" style="background: #f9f9f9; padding: 20px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #ddd;">
            <h4 style="margin-top: 0;">Session <?php echo $index + 1; ?></h4>
            
            <table class="form-table">
                <tr>
                    <th style="width: 150px;"><label>Date de début</label></th>
                    <td>
                        <input type="date" name="sessions[<?php echo $index; ?>][date_debut]" value="<?php echo esc_attr($date_debut); ?>" style="width: 100%;">
                    </td>
                </tr>
                <tr>
                    <th><label>Date de fin</label></th>
                    <td>
                        <input type="date" name="sessions[<?php echo $index; ?>][date_fin]" value="<?php echo esc_attr($date_fin); ?>" style="width: 100%;">
                    </td>
                </tr>
                <tr>
                    <th><label>Lieu</label></th>
                    <td>
                        <input type="text" name="sessions[<?php echo $index; ?>][lieu]" value="<?php echo esc_attr($lieu); ?>" placeholder="Ex: Deauville - Salle A" style="width: 100%;">
                    </td>
                </tr>
                <tr>
                    <th><label>Places disponibles</label></th>
                    <td>
                        <input type="number" name="sessions[<?php echo $index; ?>][places_dispo]" value="<?php echo esc_attr($places_dispo); ?>" min="0" placeholder="12" style="width: 100px;">
                    </td>
                </tr>
                <tr>
                    <th><label>Statut</label></th>
                    <td>
                        <select name="sessions[<?php echo $index; ?>][statut]" style="width: 200px;">
                            <option value="disponible" <?php selected($statut, 'disponible'); ?>>Places disponibles</option>
                            <option value="derniere_place" <?php selected($statut, 'derniere_place'); ?>>Dernières places</option>
                            <option value="complet" <?php selected($statut, 'complet'); ?>>Complet</option>
                            <option value="annule" <?php selected($statut, 'annule'); ?>>Annulé</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>Tarif spécifique (€)</label></th>
                    <td>
                        <input type="number" name="sessions[<?php echo $index; ?>][tarif_specifique]" value="<?php echo esc_attr($tarif_specifique); ?>" min="0" step="0.01" placeholder="Laisser vide pour tarif général" style="width: 200px;">
                        <p class="description">Si vide, le tarif général de la formation sera utilisé</p>
                    </td>
                </tr>
            </table>
            
            <button type="button" class="button remove-session" style="background: #dc3545; color: white; border: none; margin-top: 10px;">Supprimer cette session</button>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" id="add-session" class="button button-primary" style="margin-top: 10px;">+ Ajouter une session</button>
    
    <script>
    jQuery(document).ready(function($) {
        var sessionIndex = <?php echo count($sessions); ?>;
        
        $('#add-session').click(function() {
            var html = '<div class="session-item" style="background: #f9f9f9; padding: 20px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #ddd;">' +
                '<h4 style="margin-top: 0;">Session ' + (sessionIndex + 1) + '</h4>' +
                '<table class="form-table">' +
                '<tr><th style="width: 150px;"><label>Date de début</label></th><td><input type="date" name="sessions[' + sessionIndex + '][date_debut]" style="width: 100%;"></td></tr>' +
                '<tr><th><label>Date de fin</label></th><td><input type="date" name="sessions[' + sessionIndex + '][date_fin]" style="width: 100%;"></td></tr>' +
                '<tr><th><label>Lieu</label></th><td><input type="text" name="sessions[' + sessionIndex + '][lieu]" placeholder="Ex: Deauville - Salle A" style="width: 100%;"></td></tr>' +
                '<tr><th><label>Places disponibles</label></th><td><input type="number" name="sessions[' + sessionIndex + '][places_dispo]" min="0" placeholder="12" style="width: 100px;"></td></tr>' +
                '<tr><th><label>Statut</label></th><td><select name="sessions[' + sessionIndex + '][statut]" style="width: 200px;">' +
                '<option value="disponible">Places disponibles</option>' +
                '<option value="derniere_place">Dernières places</option>' +
                '<option value="complet">Complet</option>' +
                '<option value="annule">Annulé</option>' +
                '</select></td></tr>' +
                '<tr><th><label>Tarif spécifique (€)</label></th><td><input type="number" name="sessions[' + sessionIndex + '][tarif_specifique]" min="0" step="0.01" placeholder="Laisser vide pour tarif général" style="width: 200px;"><p class="description">Si vide, le tarif général de la formation sera utilisé</p></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-session" style="background: #dc3545; color: white; border: none; margin-top: 10px;">Supprimer cette session</button>' +
                '</div>';
            
            $('#sessions-container').append(html);
            sessionIndex++;
        });
        
        $(document).on('click', '.remove-session', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette session ?')) {
                $(this).closest('.session-item').remove();
            }
        });
    });
    </script>
    <?php
}

// Indicateurs
function insuffle_formation_indicateurs_callback($post) {
    $taux_satisfaction = get_post_meta($post->ID, '_formation_taux_satisfaction', true);
    $taux_reussite = get_post_meta($post->ID, '_formation_taux_reussite', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="formation_taux_satisfaction">Taux de satisfaction (%)</label></th>
            <td><input type="number" id="formation_taux_satisfaction" name="formation_taux_satisfaction" value="<?php echo esc_attr($taux_satisfaction); ?>" min="0" max="100" placeholder="98"></td>
        </tr>
        <tr>
            <th><label for="formation_taux_reussite">Taux de réussite (%)</label></th>
            <td><input type="number" id="formation_taux_reussite" name="formation_taux_reussite" value="<?php echo esc_attr($taux_reussite); ?>" min="0" max="100" placeholder="95"></td>
        </tr>
    </table>
    <?php
}

// ========================================
// 4. SAUVEGARDE DES META DONNÉES
// ========================================

function insuffle_save_formation_meta($post_id) {
    // Vérifications de sécurité
    if (!isset($_POST['insuffle_formation_nonce'])) return;
    if (!wp_verify_nonce($_POST['insuffle_formation_nonce'], 'insuffle_formation_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Sauvegarder les sessions
    if (isset($_POST['sessions']) && is_array($_POST['sessions'])) {
        $sessions = array();
        foreach ($_POST['sessions'] as $session) {
            $sessions[] = array(
                'date_debut' => sanitize_text_field($session['date_debut']),
                'date_fin' => sanitize_text_field($session['date_fin']),
                'lieu' => sanitize_text_field($session['lieu']),
                'places_dispo' => intval($session['places_dispo']),
                'statut' => sanitize_text_field($session['statut']),
                'tarif_specifique' => floatval($session['tarif_specifique']),
            );
        }
        update_post_meta($post_id, '_formation_sessions_data', $sessions);
    } else {
        delete_post_meta($post_id, '_formation_sessions_data');
    }

    // Liste de tous les autres champs à sauvegarder
    $fields = array(
        'formation_reference',
        'formation_duree_jours',
        'formation_duree_heures',
        'formation_modalite',
        'formation_lieu',
        'formation_public_vise',
        'formation_prerequis',
        'formation_niveau_requis',
        'formation_objectifs',
        'formation_competences',
        'formation_programme',
        'formation_methodes',
        'formation_moyens_techniques',
        'formation_encadrement',
        'formation_suivi',
        'formation_evaluation',
        'formation_sanction',
        'formation_accessibilite',
        'formation_tarif_inter',
        'formation_tarif_intra',
        'formation_tarif_individuel',
        'formation_financement',
        'formation_delai_acces',
        'formation_effectif_min',
        'formation_effectif_max',
        'formation_taux_satisfaction',
        'formation_taux_reussite',
        'formation_galerie',
        'formation_bouton1_texte',
        'formation_bouton1_fichier',
        'formation_bouton2_texte',
        'formation_bouton2_fichier',
        'formation_bouton3_texte',
        'formation_bouton3_fichier',
        'formation_formulaire_code',
    );

    // Sauvegarder chaque champ
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
        }
    }
}
add_action('save_post_formation', 'insuffle_save_formation_meta');

// ========================================
// 5. COLONNES PERSONNALISÉES DANS L'ADMIN
// ========================================

function insuffle_formation_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['reference'] = 'Référence';
    $new_columns['duree'] = 'Durée';
    $new_columns['modalite'] = 'Modalité';
    $new_columns['tarif'] = 'Tarif Inter';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_formation_posts_columns', 'insuffle_formation_columns');

function insuffle_formation_column_content($column, $post_id) {
    switch ($column) {
        case 'reference':
            $ref = get_post_meta($post_id, '_formation_reference', true);
            echo $ref ? esc_html($ref) : '—';
            break;
        case 'duree':
            $jours = get_post_meta($post_id, '_formation_duree_jours', true);
            $heures = get_post_meta($post_id, '_formation_duree_heures', true);
            if ($jours) {
                echo esc_html($jours) . ' jour(s)';
                if ($heures) echo ' (' . esc_html($heures) . 'h)';
            } else {
                echo '—';
            }
            break;
        case 'modalite':
            $modalite = get_post_meta($post_id, '_formation_modalite', true);
            echo $modalite ? esc_html($modalite) : '—';
            break;
        case 'tarif':
            $tarif = get_post_meta($post_id, '_formation_tarif_inter', true);
            echo $tarif ? esc_html($tarif) . ' € HT' : '—';
            break;
    }
}
add_action('manage_formation_posts_custom_column', 'insuffle_formation_column_content', 10, 2);