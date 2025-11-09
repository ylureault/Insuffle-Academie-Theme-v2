<?php
/**
 * Gestion des meta boxes pour les formateurs
 */

if (!defined('ABSPATH')) {
    exit;
}

class Formateur_Metabox {

    /**
     * Instance unique (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur
     */
    private function __construct() {
        add_action('add_meta_boxes', array($this, 'add_metaboxes'));
        add_action('save_post_formateur', array($this, 'save_metabox'));
    }

    /**
     * Ajoute les meta boxes
     */
    public function add_metaboxes() {
        add_meta_box(
            'formateur_informations',
            __('Informations du formateur', 'plugin-formateur'),
            array($this, 'render_informations_metabox'),
            'formateur',
            'normal',
            'high'
        );

        add_meta_box(
            'formateur_reseaux',
            __('Réseaux sociaux et contact', 'plugin-formateur'),
            array($this, 'render_reseaux_metabox'),
            'formateur',
            'side',
            'default'
        );

        add_meta_box(
            'formateur_parametres',
            __('Paramètres d\'affichage', 'plugin-formateur'),
            array($this, 'render_parametres_metabox'),
            'formateur',
            'side',
            'default'
        );
    }

    /**
     * Affiche la meta box des informations
     */
    public function render_informations_metabox($post) {
        wp_nonce_field('formateur_metabox_nonce', 'formateur_metabox_nonce_field');

        $titre = get_post_meta($post->ID, '_formateur_titre', true);
        $citation = get_post_meta($post->ID, '_formateur_citation', true);
        $specialites = get_post_meta($post->ID, '_formateur_specialites', true);
        $certifications = get_post_meta($post->ID, '_formateur_certifications', true);
        $experience = get_post_meta($post->ID, '_formateur_experience', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="formateur_titre"><?php _e('Titre / Fonction', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="text"
                           id="formateur_titre"
                           name="formateur_titre"
                           value="<?php echo esc_attr($titre); ?>"
                           class="large-text"
                           placeholder="Ex: Responsable pédagogique — Insuffle Académie">
                    <p class="description"><?php _e('Titre ou fonction du formateur', 'plugin-formateur'); ?></p>
                </td>
            </tr>

            <tr>
                <th><label for="formateur_citation"><?php _e('Citation / Devise', 'plugin-formateur'); ?></label></th>
                <td>
                    <textarea id="formateur_citation"
                              name="formateur_citation"
                              rows="3"
                              class="large-text"
                              placeholder="Ex: On ne forme pas à faire des ateliers..."><?php echo esc_textarea($citation); ?></textarea>
                    <p class="description"><?php _e('Citation ou devise personnelle du formateur', 'plugin-formateur'); ?></p>
                </td>
            </tr>

            <tr>
                <th><label for="formateur_specialites"><?php _e('Spécialités', 'plugin-formateur'); ?></label></th>
                <td>
                    <textarea id="formateur_specialites"
                              name="formateur_specialites"
                              rows="4"
                              class="large-text"
                              placeholder="Une spécialité par ligne"><?php echo esc_textarea($specialites); ?></textarea>
                    <p class="description"><?php _e('Domaines d\'expertise (une spécialité par ligne)', 'plugin-formateur'); ?></p>
                </td>
            </tr>

            <tr>
                <th><label for="formateur_certifications"><?php _e('Certifications', 'plugin-formateur'); ?></label></th>
                <td>
                    <textarea id="formateur_certifications"
                              name="formateur_certifications"
                              rows="4"
                              class="large-text"
                              placeholder="Une certification par ligne"><?php echo esc_textarea($certifications); ?></textarea>
                    <p class="description"><?php _e('Certifications et qualifications (une par ligne)', 'plugin-formateur'); ?></p>
                </td>
            </tr>

            <tr>
                <th><label for="formateur_experience"><?php _e('Années d\'expérience', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="number"
                           id="formateur_experience"
                           name="formateur_experience"
                           value="<?php echo esc_attr($experience); ?>"
                           min="0"
                           placeholder="10">
                    <p class="description"><?php _e('Nombre d\'années d\'expérience', 'plugin-formateur'); ?></p>
                </td>
            </tr>
        </table>

        <p class="description" style="margin-top: 20px; padding: 15px; background: #f0f0f0; border-left: 4px solid #8E2183;">
            <strong><?php _e('Biographie complète', 'plugin-formateur'); ?>:</strong><br>
            <?php _e('Utilisez l\'éditeur de contenu principal ci-dessus pour rédiger la biographie complète du formateur.', 'plugin-formateur'); ?>
        </p>
        <?php
    }

    /**
     * Affiche la meta box des réseaux sociaux
     */
    public function render_reseaux_metabox($post) {
        $email = get_post_meta($post->ID, '_formateur_email', true);
        $telephone = get_post_meta($post->ID, '_formateur_telephone', true);
        $linkedin = get_post_meta($post->ID, '_formateur_linkedin', true);
        $twitter = get_post_meta($post->ID, '_formateur_twitter', true);
        $site_web = get_post_meta($post->ID, '_formateur_site_web', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="formateur_email"><?php _e('Email', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="email"
                           id="formateur_email"
                           name="formateur_email"
                           value="<?php echo esc_attr($email); ?>"
                           class="regular-text"
                           placeholder="email@exemple.com">
                </td>
            </tr>

            <tr>
                <th><label for="formateur_telephone"><?php _e('Téléphone', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="tel"
                           id="formateur_telephone"
                           name="formateur_telephone"
                           value="<?php echo esc_attr($telephone); ?>"
                           class="regular-text"
                           placeholder="09 80 80 89 62">
                </td>
            </tr>

            <tr>
                <th><label for="formateur_linkedin"><?php _e('LinkedIn', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="url"
                           id="formateur_linkedin"
                           name="formateur_linkedin"
                           value="<?php echo esc_attr($linkedin); ?>"
                           class="regular-text"
                           placeholder="https://linkedin.com/in/...">
                </td>
            </tr>

            <tr>
                <th><label for="formateur_twitter"><?php _e('Twitter/X', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="url"
                           id="formateur_twitter"
                           name="formateur_twitter"
                           value="<?php echo esc_attr($twitter); ?>"
                           class="regular-text"
                           placeholder="https://twitter.com/...">
                </td>
            </tr>

            <tr>
                <th><label for="formateur_site_web"><?php _e('Site Web', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="url"
                           id="formateur_site_web"
                           name="formateur_site_web"
                           value="<?php echo esc_attr($site_web); ?>"
                           class="regular-text"
                           placeholder="https://...">
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Affiche la meta box des paramètres
     */
    public function render_parametres_metabox($post) {
        $ordre = get_post_meta($post->ID, '_formateur_ordre', true);
        $afficher_citation = get_post_meta($post->ID, '_formateur_afficher_citation', true);
        $afficher_specialites = get_post_meta($post->ID, '_formateur_afficher_specialites', true);
        $afficher_contact = get_post_meta($post->ID, '_formateur_afficher_contact', true);

        // Valeurs par défaut
        $afficher_citation = $afficher_citation !== '' ? $afficher_citation : '1';
        $afficher_specialites = $afficher_specialites !== '' ? $afficher_specialites : '1';
        $afficher_contact = $afficher_contact !== '' ? $afficher_contact : '1';
        ?>
        <table class="form-table">
            <tr>
                <th><label for="formateur_ordre"><?php _e('Ordre d\'affichage', 'plugin-formateur'); ?></label></th>
                <td>
                    <input type="number"
                           id="formateur_ordre"
                           name="formateur_ordre"
                           value="<?php echo esc_attr($ordre ? $ordre : 1); ?>"
                           min="1"
                           style="width: 80px;">
                    <p class="description"><?php _e('Ordre d\'apparition dans la liste', 'plugin-formateur'); ?></p>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label>
                        <input type="checkbox"
                               name="formateur_afficher_citation"
                               value="1"
                               <?php checked($afficher_citation, '1'); ?>>
                        <?php _e('Afficher la citation', 'plugin-formateur'); ?>
                    </label>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label>
                        <input type="checkbox"
                               name="formateur_afficher_specialites"
                               value="1"
                               <?php checked($afficher_specialites, '1'); ?>>
                        <?php _e('Afficher les spécialités', 'plugin-formateur'); ?>
                    </label>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label>
                        <input type="checkbox"
                               name="formateur_afficher_contact"
                               value="1"
                               <?php checked($afficher_contact, '1'); ?>>
                        <?php _e('Afficher les informations de contact', 'plugin-formateur'); ?>
                    </label>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Sauvegarde les meta données
     */
    public function save_metabox($post_id) {
        // Vérifications de sécurité
        if (!isset($_POST['formateur_metabox_nonce_field'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['formateur_metabox_nonce_field'], 'formateur_metabox_nonce')) {
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
            'formateur_titre',
            'formateur_citation',
            'formateur_specialites',
            'formateur_certifications',
            'formateur_experience',
            'formateur_email',
            'formateur_telephone',
            'formateur_linkedin',
            'formateur_twitter',
            'formateur_site_web',
            'formateur_ordre',
        );

        // Sauvegarder chaque champ
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }

        // Champs checkbox
        $checkboxes = array(
            'formateur_afficher_citation',
            'formateur_afficher_specialites',
            'formateur_afficher_contact',
        );

        foreach ($checkboxes as $checkbox) {
            $value = isset($_POST[$checkbox]) ? '1' : '0';
            update_post_meta($post_id, '_' . $checkbox, $value);
        }
    }
}
