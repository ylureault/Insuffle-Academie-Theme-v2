<?php
/**
 * Metaboxes pour les formations - Conformité Qualiopi
 */

// Ajouter les metaboxes
function insuffle_add_formation_metaboxes() {
    // Informations générales
    add_meta_box(
        'formation_general',
        'Informations générales',
        'insuffle_formation_general_callback',
        'formation',
        'normal',
        'high'
    );
    
    // Objectifs et programme
    add_meta_box(
        'formation_programme',
        'Objectifs et programme',
        'insuffle_formation_programme_callback',
        'formation',
        'normal',
        'high'
    );
    
    // Modalités pédagogiques
    add_meta_box(
        'formation_modalites',
        'Modalités pédagogiques',
        'insuffle_formation_modalites_callback',
        'formation',
        'normal',
        'high'
    );
    
    // Tarifs et sessions
    add_meta_box(
        'formation_tarifs',
        'Tarifs et sessions',
        'insuffle_formation_tarifs_callback',
        'formation',
        'side',
        'default'
    );
    
    // Indicateurs Qualiopi
    add_meta_box(
        'formation_indicateurs',
        'Indicateurs Qualiopi',
        'insuffle_formation_indicateurs_callback',
        'formation',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'insuffle_add_formation_metaboxes');

// Callback Informations générales
function insuffle_formation_general_callback($post) {
    wp_nonce_field('insuffle_formation_save', 'insuffle_formation_nonce');
    
    // Récupérer les valeurs
    $reference = get_post_meta($post->ID, '_formation_reference', true);
    $duree_heures = get_post_meta($post->ID, '_formation_duree_heures', true);
    $duree_jours = get_post_meta($post->ID, '_formation_duree_jours', true);
    $modalite = get_post_meta($post->ID, '_formation_modalite', true);
    $lieu = get_post_meta($post->ID, '_formation_lieu', true);
    $niveau_requis = get_post_meta($post->ID, '_formation_niveau_requis', true);
    $public_vise = get_post_meta($post->ID, '_formation_public_vise', true);
    $prerequis = get_post_meta($post->ID, '_formation_prerequis', true);
    $effectif_min = get_post_meta($post->ID, '_formation_effectif_min', true);
    $effectif_max = get_post_meta($post->ID, '_formation_effectif_max', true);
    $delai_acces = get_post_meta($post->ID, '_formation_delai_acces', true);
    $accessibilite = get_post_meta($post->ID, '_formation_accessibilite', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="formation_reference">Référence formation</label></th>
            <td>
                <input type="text" id="formation_reference" name="formation_reference" 
                       value="<?php echo esc_attr($reference); ?>" class="regular-text" />
                <p class="description">Code référence unique de la formation</p>
            </td>
        </tr>
        
        <tr>
            <th><label>Durée</label></th>
            <td>
                <input type="number" name="formation_duree_jours" 
                       value="<?php echo esc_attr($duree_jours); ?>" style="width: 80px" /> jours
                &nbsp;&nbsp;
                <input type="number" name="formation_duree_heures" 
                       value="<?php echo esc_attr($duree_heures); ?>" style="width: 80px" /> heures
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_modalite">Modalité</label></th>
            <td>
                <select id="formation_modalite" name="formation_modalite">
                    <option value="">-- Sélectionner --</option>
                    <option value="Présentiel" <?php selected($modalite, 'Présentiel'); ?>>Présentiel</option>
                    <option value="Distanciel" <?php selected($modalite, 'Distanciel'); ?>>Distanciel</option>
                    <option value="Présentiel ou distanciel" <?php selected($modalite, 'Présentiel ou distanciel'); ?>>Présentiel ou distanciel</option>
                    <option value="Blended learning" <?php selected($modalite, 'Blended learning'); ?>>Blended learning</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_lieu">Lieu</label></th>
            <td>
                <input type="text" id="formation_lieu" name="formation_lieu" 
                       value="<?php echo esc_attr($lieu); ?>" class="regular-text" 
                       placeholder="Ex: Deauville ou Dans vos locaux" />
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_public_vise">Public visé</label></th>
            <td>
                <textarea id="formation_public_vise" name="formation_public_vise" 
                          rows="3" class="large-text"><?php echo esc_textarea($public_vise); ?></textarea>
                <p class="description">Décrire le public concerné par cette formation</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_prerequis">Prérequis</label></th>
            <td>
                <textarea id="formation_prerequis" name="formation_prerequis" 
                          rows="3" class="large-text"><?php echo esc_textarea($prerequis); ?></textarea>
                <p class="description">Indiquer les prérequis nécessaires ou "Aucun prérequis"</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_niveau_requis">Niveau requis</label></th>
            <td>
                <select id="formation_niveau_requis" name="formation_niveau_requis">
                    <option value="">-- Sélectionner --</option>
                    <option value="Débutant" <?php selected($niveau_requis, 'Débutant'); ?>>Débutant</option>
                    <option value="Intermédiaire" <?php selected($niveau_requis, 'Intermédiaire'); ?>>Intermédiaire</option>
                    <option value="Avancé" <?php selected($niveau_requis, 'Avancé'); ?>>Avancé</option>
                    <option value="Expert" <?php selected($niveau_requis, 'Expert'); ?>>Expert</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th><label>Effectif</label></th>
            <td>
                Min: <input type="number" name="formation_effectif_min" 
                           value="<?php echo esc_attr($effectif_min); ?>" style="width: 60px" />
                &nbsp;&nbsp;
                Max: <input type="number" name="formation_effectif_max" 
                           value="<?php echo esc_attr($effectif_max); ?>" style="width: 60px" />
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_delai_acces">Délai d'accès</label></th>
            <td>
                <input type="text" id="formation_delai_acces" name="formation_delai_acces" 
                       value="<?php echo esc_attr($delai_acces); ?>" class="regular-text" 
                       placeholder="Ex: 2 semaines" />
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_accessibilite">Accessibilité PSH</label></th>
            <td>
                <textarea id="formation_accessibilite" name="formation_accessibilite" 
                          rows="3" class="large-text"><?php echo esc_textarea($accessibilite); ?></textarea>
                <p class="description">Modalités d'accueil des personnes en situation de handicap</p>
            </td>
        </tr>
    </table>
    <?php
}

// Callback Objectifs et programme
function insuffle_formation_programme_callback($post) {
    $objectifs = get_post_meta($post->ID, '_formation_objectifs', true);
    $competences = get_post_meta($post->ID, '_formation_competences', true);
    $programme = get_post_meta($post->ID, '_formation_programme', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="formation_objectifs">Objectifs pédagogiques</label></th>
            <td>
                <textarea id="formation_objectifs" name="formation_objectifs" 
                          rows="6" class="large-text"><?php echo esc_textarea($objectifs); ?></textarea>
                <p class="description">Un objectif par ligne</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_competences">Compétences visées</label></th>
            <td>
                <textarea id="formation_competences" name="formation_competences" 
                          rows="4" class="large-text"><?php echo esc_textarea($competences); ?></textarea>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_programme">Programme détaillé</label></th>
            <td>
                <textarea id="formation_programme" name="formation_programme" 
                          rows="10" class="large-text"><?php echo esc_textarea($programme); ?></textarea>
                <p class="description">Détailler le programme jour par jour ou module par module</p>
            </td>
        </tr>
    </table>
    <?php
}

// Callback Modalités pédagogiques
function insuffle_formation_modalites_callback($post) {
    $methodes = get_post_meta($post->ID, '_formation_methodes', true);
    $moyens_techniques = get_post_meta($post->ID, '_formation_moyens_techniques', true);
    $encadrement = get_post_meta($post->ID, '_formation_encadrement', true);
    $suivi = get_post_meta($post->ID, '_formation_suivi', true);
    $evaluation = get_post_meta($post->ID, '_formation_evaluation', true);
    $sanction = get_post_meta($post->ID, '_formation_sanction', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="formation_methodes">Méthodes pédagogiques</label></th>
            <td>
                <textarea id="formation_methodes" name="formation_methodes" 
                          rows="4" class="large-text"><?php echo esc_textarea($methodes); ?></textarea>
                <p class="description">Ex: Alternance théorie/pratique, études de cas, mises en situation...</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_moyens_techniques">Moyens techniques</label></th>
            <td>
                <textarea id="formation_moyens_techniques" name="formation_moyens_techniques" 
                          rows="4" class="large-text"><?php echo esc_textarea($moyens_techniques); ?></textarea>
                <p class="description">Matériel et ressources mis à disposition</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_encadrement">Encadrement</label></th>
            <td>
                <textarea id="formation_encadrement" name="formation_encadrement" 
                          rows="3" class="large-text"><?php echo esc_textarea($encadrement); ?></textarea>
                <p class="description">Qualification des formateurs</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_suivi">Modalités de suivi</label></th>
            <td>
                <textarea id="formation_suivi" name="formation_suivi" 
                          rows="3" class="large-text"><?php echo esc_textarea($suivi); ?></textarea>
                <p class="description">Ex: Feuilles de présence, attestations...</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_evaluation">Modalités d'évaluation</label></th>
            <td>
                <textarea id="formation_evaluation" name="formation_evaluation" 
                          rows="4" class="large-text"><?php echo esc_textarea($evaluation); ?></textarea>
                <p class="description">Ex: QCM, mises en situation, évaluation continue...</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="formation_sanction">Sanction de la formation</label></th>
            <td>
                <input type="text" id="formation_sanction" name="formation_sanction" 
                       value="<?php echo esc_attr($sanction); ?>" class="large-text" 
                       placeholder="Ex: Attestation de fin de formation" />
            </td>
        </tr>
    </table>
    <?php
}

// Callback Tarifs
function insuffle_formation_tarifs_callback($post) {
    $tarif_inter = get_post_meta($post->ID, '_formation_tarif_inter', true);
    $tarif_intra = get_post_meta($post->ID, '_formation_tarif_intra', true);
    $tarif_individuel = get_post_meta($post->ID, '_formation_tarif_individuel', true);
    $financement = get_post_meta($post->ID, '_formation_financement', true);
    $sessions = get_post_meta($post->ID, '_formation_sessions', true);
    ?>
    
    <p>
        <label>Tarif Inter-entreprises (€ HT)</label><br>
        <input type="number" name="formation_tarif_inter" 
               value="<?php echo esc_attr($tarif_inter); ?>" style="width: 100%" />
    </p>
    
    <p>
        <label>Tarif Intra-entreprise (€ HT)</label><br>
        <input type="number" name="formation_tarif_intra" 
               value="<?php echo esc_attr($tarif_intra); ?>" style="width: 100%" />
    </p>
    
    <p>
        <label>Tarif Individuel (€ HT)</label><br>
        <input type="number" name="formation_tarif_individuel" 
               value="<?php echo esc_attr($tarif_individuel); ?>" style="width: 100%" />
    </p>
    
    <p>
        <label>Financement</label><br>
        <input type="text" name="formation_financement" 
               value="<?php echo esc_attr($financement); ?>" style="width: 100%" 
               placeholder="Ex: Eligible CPF, OPCO" />
    </p>
    
    <p>
        <label>Prochaines sessions</label><br>
        <textarea name="formation_sessions" rows="4" style="width: 100%"><?php echo esc_textarea($sessions); ?></textarea>
        <small>Une date par ligne</small>
    </p>
    <?php
}

// Callback Indicateurs
function insuffle_formation_indicateurs_callback($post) {
    $taux_satisfaction = get_post_meta($post->ID, '_formation_taux_satisfaction', true);
    $taux_reussite = get_post_meta($post->ID, '_formation_taux_reussite', true);
    ?>
    
    <p>
        <label>Taux de satisfaction (%)</label><br>
        <input type="number" name="formation_taux_satisfaction" 
               value="<?php echo esc_attr($taux_satisfaction); ?>" 
               min="0" max="100" style="width: 100%" />
    </p>
    
    <p>
        <label>Taux de réussite (%)</label><br>
        <input type="number" name="formation_taux_reussite" 
               value="<?php echo esc_attr($taux_reussite); ?>" 
               min="0" max="100" style="width: 100%" />
    </p>
    <?php
}

// Sauvegarder les métadonnées
function insuffle_save_formation_meta($post_id) {
    // Vérifications de sécurité
    if (!isset($_POST['insuffle_formation_nonce']) || 
        !wp_verify_nonce($_POST['insuffle_formation_nonce'], 'insuffle_formation_save')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Liste des champs à sauvegarder
    $fields = array(
        'formation_reference',
        'formation_duree_heures',
        'formation_duree_jours',
        'formation_modalite',
        'formation_lieu',
        'formation_niveau_requis',
        'formation_public_vise',
        'formation_prerequis',
        'formation_effectif_min',
        'formation_effectif_max',
        'formation_delai_acces',
        'formation_accessibilite',
        'formation_objectifs',
        'formation_competences',
        'formation_programme',
        'formation_methodes',
        'formation_moyens_techniques',
        'formation_encadrement',
        'formation_suivi',
        'formation_evaluation',
        'formation_sanction',
        'formation_tarif_inter',
        'formation_tarif_intra',
        'formation_tarif_individuel',
        'formation_financement',
        'formation_sessions',
        'formation_taux_satisfaction',
        'formation_taux_reussite',
    );
    
    // Sauvegarder chaque champ
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_formation', 'insuffle_save_formation_meta');