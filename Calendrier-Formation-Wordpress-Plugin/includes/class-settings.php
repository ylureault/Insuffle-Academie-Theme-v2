<?php
/**
 * Page de paramètres du plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Settings {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_head', array($this, 'output_custom_colors'), 100);
    }

    /**
     * Helper pour récupérer une valeur de paramètre
     */
    public static function get_setting($key, $default = '') {
        $settings = get_option('cf_settings', array());
        return isset($settings[$key]) ? $settings[$key] : $default;
    }

    /**
     * Injecte les couleurs personnalisées dans le CSS
     */
    public function output_custom_colors() {
        $primary = self::get_setting('color_primary', '#8E2183');
        $secondary = self::get_setting('color_secondary', '#9c27b0');
        $success = self::get_setting('color_success', '#4caf50');
        $warning = self::get_setting('color_warning', '#ff9800');
        $danger = self::get_setting('color_danger', '#f44336');

        ?>
        <style id="cf-custom-colors">
            :root {
                --insuffle-primary: <?php echo esc_attr($primary); ?>;
                --insuffle-secondary: <?php echo esc_attr($secondary); ?>;
                --insuffle-green: <?php echo esc_attr($success); ?>;
                --insuffle-orange: <?php echo esc_attr($warning); ?>;
                --insuffle-red: <?php echo esc_attr($danger); ?>;
            }
        </style>
        <?php
    }

    /**
     * Ajoute la page de paramètres
     */
    public function add_settings_page() {
        add_options_page(
            __('Calendrier Formation - Paramètres', 'calendrier-formation'),
            __('Calendrier Formation', 'calendrier-formation'),
            'manage_options',
            'calendrier-formation',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Enregistre les paramètres
     */
    public function register_settings() {
        register_setting('cf_settings_group', 'cf_settings', array($this, 'sanitize_settings'));

        add_settings_section(
            'cf_general_section',
            __('Paramètres généraux', 'calendrier-formation'),
            array($this, 'render_general_section'),
            'calendrier-formation'
        );

        add_settings_field(
            'cf_formations_parent_id',
            __('ID de la page parent "Formations"', 'calendrier-formation'),
            array($this, 'render_parent_id_field'),
            'calendrier-formation',
            'cf_general_section'
        );

        add_settings_field(
            'cf_inscription_page_id',
            __('Page d\'inscription', 'calendrier-formation'),
            array($this, 'render_inscription_page_field'),
            'calendrier-formation',
            'cf_general_section'
        );

        add_settings_field(
            'cf_form_url',
            __('OU URL externe du formulaire d\'inscription', 'calendrier-formation'),
            array($this, 'render_form_url_field'),
            'calendrier-formation',
            'cf_general_section'
        );

        add_settings_field(
            'cf_contact_page_id',
            __('Page de contact', 'calendrier-formation'),
            array($this, 'render_contact_page_field'),
            'calendrier-formation',
            'cf_general_section'
        );

        add_settings_field(
            'cf_email_admin',
            __('Email de notification', 'calendrier-formation'),
            array($this, 'render_email_admin_field'),
            'calendrier-formation',
            'cf_general_section'
        );

        // === SECTION COULEURS ===
        add_settings_section(
            'cf_colors_section',
            __('🎨 Couleurs de la marque', 'calendrier-formation'),
            array($this, 'render_colors_section'),
            'calendrier-formation'
        );

        add_settings_field(
            'cf_color_primary',
            __('Couleur principale', 'calendrier-formation'),
            array($this, 'render_color_primary_field'),
            'calendrier-formation',
            'cf_colors_section'
        );

        add_settings_field(
            'cf_color_secondary',
            __('Couleur secondaire', 'calendrier-formation'),
            array($this, 'render_color_secondary_field'),
            'calendrier-formation',
            'cf_colors_section'
        );

        add_settings_field(
            'cf_color_success',
            __('Couleur succès (places disponibles)', 'calendrier-formation'),
            array($this, 'render_color_success_field'),
            'calendrier-formation',
            'cf_colors_section'
        );

        add_settings_field(
            'cf_color_warning',
            __('Couleur avertissement (bientôt complet)', 'calendrier-formation'),
            array($this, 'render_color_warning_field'),
            'calendrier-formation',
            'cf_colors_section'
        );

        add_settings_field(
            'cf_color_danger',
            __('Couleur erreur (complet)', 'calendrier-formation'),
            array($this, 'render_color_danger_field'),
            'calendrier-formation',
            'cf_colors_section'
        );

        // === SECTION TEXTES ===
        add_settings_section(
            'cf_texts_section',
            __('📝 Textes personnalisables', 'calendrier-formation'),
            array($this, 'render_texts_section'),
            'calendrier-formation'
        );

        add_settings_field(
            'cf_text_catalog_title',
            __('Titre du catalogue', 'calendrier-formation'),
            array($this, 'render_text_catalog_title_field'),
            'calendrier-formation',
            'cf_texts_section'
        );

        add_settings_field(
            'cf_text_booking_title',
            __('Titre du formulaire de réservation', 'calendrier-formation'),
            array($this, 'render_text_booking_title_field'),
            'calendrier-formation',
            'cf_texts_section'
        );

        add_settings_field(
            'cf_text_button_reserve',
            __('Texte du bouton de réservation', 'calendrier-formation'),
            array($this, 'render_text_button_reserve_field'),
            'calendrier-formation',
            'cf_texts_section'
        );

        add_settings_field(
            'cf_text_button_submit',
            __('Texte du bouton d\'envoi du formulaire', 'calendrier-formation'),
            array($this, 'render_text_button_submit_field'),
            'calendrier-formation',
            'cf_texts_section'
        );
    }

    /**
     * Affiche la page de paramètres
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Récupérer les statistiques
        global $wpdb;
        $table_sessions = $wpdb->prefix . 'cf_sessions';
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        $settings = get_option('cf_settings', array());
        $parent_id = isset($settings['formations_parent_id']) ? $settings['formations_parent_id'] : 51;

        $total_sessions = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active'");
        $upcoming_sessions = $wpdb->get_var("SELECT COUNT(*) FROM $table_sessions WHERE status = 'active' AND date_debut >= NOW()");
        $total_bookings = $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings");
        $pending_bookings = $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings WHERE status = 'pending'");

        // Récupérer les pages de formation (enfants de la page parent)
        $formation_pages = get_pages(array(
            'child_of' => $parent_id,
            'sort_column' => 'post_title',
        ));

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="cf-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
                <div class="cf-stat-box" style="background: #fff; padding: 20px; border-left: 4px solid #2271b1; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 32px; font-weight: 600; color: #2271b1;"><?php echo esc_html($total_sessions); ?></div>
                    <div style="color: #666; margin-top: 5px;"><?php _e('Sessions totales', 'calendrier-formation'); ?></div>
                </div>
                <div class="cf-stat-box" style="background: #fff; padding: 20px; border-left: 4px solid #46b450; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 32px; font-weight: 600; color: #46b450;"><?php echo esc_html($upcoming_sessions); ?></div>
                    <div style="color: #666; margin-top: 5px;"><?php _e('Sessions à venir', 'calendrier-formation'); ?></div>
                </div>
                <div class="cf-stat-box" style="background: #fff; padding: 20px; border-left: 4px solid #00a0d2; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 32px; font-weight: 600; color: #00a0d2;"><?php echo esc_html($total_bookings); ?></div>
                    <div style="color: #666; margin-top: 5px;"><?php _e('Réservations totales', 'calendrier-formation'); ?></div>
                </div>
                <div class="cf-stat-box" style="background: #fff; padding: 20px; border-left: 4px solid #f56e28; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 32px; font-weight: 600; color: #f56e28;"><?php echo esc_html($pending_bookings); ?></div>
                    <div style="color: #666; margin-top: 5px;"><?php _e('En attente', 'calendrier-formation'); ?></div>
                </div>
            </div>

            <div class="cf-info-box" style="background: #e7f3ff; border-left: 4px solid #2271b1; padding: 15px; margin: 20px 0;">
                <h3 style="margin-top: 0;"><?php _e('Comment ça fonctionne ?', 'calendrier-formation'); ?></h3>
                <p><?php _e('Ce plugin ajoute automatiquement la gestion des sessions sur toutes les pages enfants de votre page "Formations".', 'calendrier-formation'); ?></p>
                <ul style="margin-left: 20px;">
                    <li><?php printf(__('<strong>Page parent :</strong> ID %d - <a href="%s" target="_blank">%s</a>', 'calendrier-formation'),
                        $parent_id,
                        get_edit_post_link($parent_id),
                        get_the_title($parent_id)
                    ); ?></li>
                    <li><?php printf(__('<strong>Pages de formation détectées :</strong> %d', 'calendrier-formation'), count($formation_pages)); ?></li>
                </ul>
                <?php if (!empty($formation_pages)): ?>
                    <div style="margin-top: 15px;">
                        <strong><?php _e('Vos pages de formation :', 'calendrier-formation'); ?></strong>
                        <ul style="margin-left: 20px; margin-top: 10px;">
                            <?php foreach ($formation_pages as $page): ?>
                                <li>
                                    <a href="<?php echo get_edit_post_link($page->ID); ?>">
                                        <?php echo esc_html($page->post_title); ?>
                                    </a>
                                    (ID: <?php echo $page->ID; ?>)
                                    - <a href="<?php echo get_permalink($page->ID); ?>" target="_blank"><?php _e('Voir', 'calendrier-formation'); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="notice notice-warning inline" style="margin-top: 15px;">
                        <p><?php printf(__('Aucune page enfant trouvée pour la page ID %d. Créez des pages enfants pour commencer à ajouter des sessions.', 'calendrier-formation'), $parent_id); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <form action="options.php" method="post">
                <?php
                settings_fields('cf_settings_group');
                do_settings_sections('calendrier-formation');
                submit_button(__('Enregistrer les paramètres', 'calendrier-formation'));
                ?>
            </form>

            <div class="cf-help-section" style="background: #fff; padding: 20px; margin-top: 20px; border-left: 4px solid #2271b1;">
                <h2><?php _e('Utilisation du shortcode', 'calendrier-formation'); ?></h2>
                <p><?php _e('Pour afficher les sessions de formation sur une page, ajoutez le shortcode suivant dans le contenu de votre page :', 'calendrier-formation'); ?></p>
                <code style="display: block; background: #f5f5f5; padding: 10px; margin: 10px 0;">[calendrier_formation]</code>
                <p><?php _e('Le shortcode affichera automatiquement les sessions de la page courante.', 'calendrier-formation'); ?></p>

                <p><strong><?php _e('Options disponibles :', 'calendrier-formation'); ?></strong></p>
                <ul style="margin-left: 20px;">
                    <li><code>[calendrier_formation post_id="123"]</code> - <?php _e('Afficher les sessions d\'une formation spécifique', 'calendrier-formation'); ?></li>
                    <li><code>[calendrier_formation limit="5"]</code> - <?php _e('Limiter le nombre de sessions affichées', 'calendrier-formation'); ?></li>
                    <li><code>[calendrier_formation show_past="oui"]</code> - <?php _e('Afficher aussi les sessions passées', 'calendrier-formation'); ?></li>
                    <li><code>[calendrier_formation display="table"]</code> - <?php _e('Afficher en vue tableau (idéal pour 10+ sessions)', 'calendrier-formation'); ?></li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Section générale
     */
    public function render_general_section() {
        echo '<p>' . __('Configurez les paramètres du calendrier de formation.', 'calendrier-formation') . '</p>';
    }

    /**
     * Champ : ID de la page parent
     */
    public function render_parent_id_field() {
        $options = get_option('cf_settings', array());
        $parent_id = isset($options['formations_parent_id']) ? $options['formations_parent_id'] : 51;

        $parent_page = get_post($parent_id);
        $parent_title = $parent_page ? $parent_page->post_title : __('Page introuvable', 'calendrier-formation');

        echo '<input type="number" name="cf_settings[formations_parent_id]" value="' . esc_attr($parent_id) . '" class="small-text">';
        echo ' <span class="description">' . sprintf(__('Actuellement : %s', 'calendrier-formation'), '<strong>' . esc_html($parent_title) . '</strong>') . '</span>';
        echo '<p class="description">' . __('Toutes les pages enfants de cette page pourront avoir des sessions de formation.', 'calendrier-formation') . '</p>';
    }

    /**
     * Champ : ID de la page d'inscription
     */
    public function render_inscription_page_field() {
        $options = get_option('cf_settings', array());
        $inscription_page_id = isset($options['inscription_page_id']) ? $options['inscription_page_id'] : 167;

        $inscription_page = get_post($inscription_page_id);
        $inscription_title = $inscription_page ? $inscription_page->post_title : __('Page introuvable', 'calendrier-formation');

        echo '<input type="number" name="cf_settings[inscription_page_id]" value="' . esc_attr($inscription_page_id) . '" class="small-text">';
        echo ' <span class="description">' . sprintf(__('Actuellement : %s', 'calendrier-formation'), '<strong>' . esc_html($inscription_title) . '</strong>') . '</span>';
        echo '<p class="description">' . __('ID de la page WordPress vers laquelle rediriger pour les inscriptions.', 'calendrier-formation') . '</p>';
    }

    /**
     * Champ : ID de la page de contact
     */
    public function render_contact_page_field() {
        $options = get_option('cf_settings', array());
        $contact_page_id = isset($options['contact_page_id']) ? $options['contact_page_id'] : 0;

        if ($contact_page_id) {
            $contact_page = get_post($contact_page_id);
            $contact_title = $contact_page ? $contact_page->post_title : __('Page introuvable', 'calendrier-formation');
        } else {
            $contact_title = __('Non configurée', 'calendrier-formation');
        }

        echo '<input type="number" name="cf_settings[contact_page_id]" value="' . esc_attr($contact_page_id) . '" class="small-text">';
        echo ' <span class="description">' . sprintf(__('Actuellement : %s', 'calendrier-formation'), '<strong>' . esc_html($contact_title) . '</strong>') . '</span>';
        echo '<p class="description">' . __('ID de la page de contact pour le bouton "+ d\'infos" dans la vue tableau.', 'calendrier-formation') . '</p>';
    }

    /**
     * Champ : URL du formulaire
     */
    public function render_form_url_field() {
        $options = get_option('cf_settings', array());
        $form_url = isset($options['form_url']) ? $options['form_url'] : '';

        echo '<input type="url" name="cf_settings[form_url]" value="' . esc_attr($form_url) . '" class="regular-text">';
        echo '<p class="description">' . __('Si vous préférez utiliser une URL externe plutôt qu\'une page WordPress.', 'calendrier-formation') . '</p>';
        echo '<p class="description">' . __('Les paramètres de la session seront automatiquement ajoutés à l\'URL (session_id, formation, date, etc.).', 'calendrier-formation') . '</p>';
    }

    /**
     * Champ : Email admin
     */
    public function render_email_admin_field() {
        $options = get_option('cf_settings', array());
        $email = isset($options['email_admin']) ? $options['email_admin'] : get_option('admin_email');

        echo '<input type="email" name="cf_settings[email_admin]" value="' . esc_attr($email) . '" class="regular-text">';
        echo '<p class="description">' . __('Email pour recevoir les notifications de nouvelles réservations.', 'calendrier-formation') . '</p>';
    }

    // === RENDER SECTIONS ===

    public function render_colors_section() {
        echo '<p>' . __('Personnalisez les couleurs de votre marque. Les couleurs Insuffle Académie sont pré-remplies par défaut.', 'calendrier-formation') . '</p>';
    }

    public function render_texts_section() {
        echo '<p>' . __('Personnalisez les titres et textes des boutons affichés sur votre site.', 'calendrier-formation') . '</p>';
    }

    // === RENDER COLOR FIELDS ===

    public function render_color_primary_field() {
        $options = get_option('cf_settings', array());
        $color = isset($options['color_primary']) ? $options['color_primary'] : '#8E2183';

        echo '<input type="color" name="cf_settings[color_primary]" value="' . esc_attr($color) . '" style="height: 40px;">';
        echo ' <input type="text" value="' . esc_attr($color) . '" readonly class="regular-text" style="vertical-align: middle;">';
        echo '<p class="description">' . __('Couleur principale (violet Insuffle par défaut)', 'calendrier-formation') . '</p>';
    }

    public function render_color_secondary_field() {
        $options = get_option('cf_settings', array());
        $color = isset($options['color_secondary']) ? $options['color_secondary'] : '#9c27b0';

        echo '<input type="color" name="cf_settings[color_secondary]" value="' . esc_attr($color) . '" style="height: 40px;">';
        echo ' <input type="text" value="' . esc_attr($color) . '" readonly class="regular-text" style="vertical-align: middle;">';
        echo '<p class="description">' . __('Couleur secondaire pour les gradients', 'calendrier-formation') . '</p>';
    }

    public function render_color_success_field() {
        $options = get_option('cf_settings', array());
        $color = isset($options['color_success']) ? $options['color_success'] : '#4caf50';

        echo '<input type="color" name="cf_settings[color_success]" value="' . esc_attr($color) . '" style="height: 40px;">';
        echo ' <input type="text" value="' . esc_attr($color) . '" readonly class="regular-text" style="vertical-align: middle;">';
        echo '<p class="description">' . __('Couleur pour "Places disponibles"', 'calendrier-formation') . '</p>';
    }

    public function render_color_warning_field() {
        $options = get_option('cf_settings', array());
        $color = isset($options['color_warning']) ? $options['color_warning'] : '#ff9800';

        echo '<input type="color" name="cf_settings[color_warning]" value="' . esc_attr($color) . '" style="height: 40px;">';
        echo ' <input type="text" value="' . esc_attr($color) . '" readonly class="regular-text" style="vertical-align: middle;">';
        echo '<p class="description">' . __('Couleur pour "Bientôt complet"', 'calendrier-formation') . '</p>';
    }

    public function render_color_danger_field() {
        $options = get_option('cf_settings', array());
        $color = isset($options['color_danger']) ? $options['color_danger'] : '#f44336';

        echo '<input type="color" name="cf_settings[color_danger]" value="' . esc_attr($color) . '" style="height: 40px;">';
        echo ' <input type="text" value="' . esc_attr($color) . '" readonly class="regular-text" style="vertical-align: middle;">';
        echo '<p class="description">' . __('Couleur pour "Complet"', 'calendrier-formation') . '</p>';
    }

    // === RENDER TEXT FIELDS ===

    public function render_text_catalog_title_field() {
        $options = get_option('cf_settings', array());
        $text = isset($options['text_catalog_title']) ? $options['text_catalog_title'] : 'Nos Formations Disponibles';

        echo '<input type="text" name="cf_settings[text_catalog_title]" value="' . esc_attr($text) . '" class="regular-text">';
        echo '<p class="description">' . __('Titre affiché en haut du catalogue de sessions', 'calendrier-formation') . '</p>';
    }

    public function render_text_booking_title_field() {
        $options = get_option('cf_settings', array());
        $text = isset($options['text_booking_title']) ? $options['text_booking_title'] : 'Demande d\'inscription';

        echo '<input type="text" name="cf_settings[text_booking_title]" value="' . esc_attr($text) . '" class="regular-text">';
        echo '<p class="description">' . __('Titre du formulaire de réservation', 'calendrier-formation') . '</p>';
    }

    public function render_text_button_reserve_field() {
        $options = get_option('cf_settings', array());
        $text = isset($options['text_button_reserve']) ? $options['text_button_reserve'] : 'Réserver ma place';

        echo '<input type="text" name="cf_settings[text_button_reserve]" value="' . esc_attr($text) . '" class="regular-text">';
        echo '<p class="description">' . __('Texte du bouton pour réserver une session', 'calendrier-formation') . '</p>';
    }

    public function render_text_button_submit_field() {
        $options = get_option('cf_settings', array());
        $text = isset($options['text_button_submit']) ? $options['text_button_submit'] : 'Envoyer ma demande';

        echo '<input type="text" name="cf_settings[text_button_submit]" value="' . esc_attr($text) . '" class="regular-text">';
        echo '<p class="description">' . __('Texte du bouton de soumission du formulaire', 'calendrier-formation') . '</p>';
    }

    /**
     * Validation des paramètres
     */
    public function sanitize_settings($input) {
        $sanitized = array();

        if (isset($input['formations_parent_id'])) {
            $sanitized['formations_parent_id'] = intval($input['formations_parent_id']);
        }

        if (isset($input['inscription_page_id'])) {
            $sanitized['inscription_page_id'] = intval($input['inscription_page_id']);
        }

        if (isset($input['contact_page_id'])) {
            $sanitized['contact_page_id'] = intval($input['contact_page_id']);
        }

        if (isset($input['form_url'])) {
            $sanitized['form_url'] = esc_url_raw($input['form_url']);
        }

        if (isset($input['email_admin'])) {
            $sanitized['email_admin'] = sanitize_email($input['email_admin']);
        }

        // Sanitize colors
        if (isset($input['color_primary'])) {
            $sanitized['color_primary'] = sanitize_hex_color($input['color_primary']);
        }
        if (isset($input['color_secondary'])) {
            $sanitized['color_secondary'] = sanitize_hex_color($input['color_secondary']);
        }
        if (isset($input['color_success'])) {
            $sanitized['color_success'] = sanitize_hex_color($input['color_success']);
        }
        if (isset($input['color_warning'])) {
            $sanitized['color_warning'] = sanitize_hex_color($input['color_warning']);
        }
        if (isset($input['color_danger'])) {
            $sanitized['color_danger'] = sanitize_hex_color($input['color_danger']);
        }

        // Sanitize texts
        if (isset($input['text_catalog_title'])) {
            $sanitized['text_catalog_title'] = sanitize_text_field($input['text_catalog_title']);
        }
        if (isset($input['text_booking_title'])) {
            $sanitized['text_booking_title'] = sanitize_text_field($input['text_booking_title']);
        }
        if (isset($input['text_button_reserve'])) {
            $sanitized['text_button_reserve'] = sanitize_text_field($input['text_button_reserve']);
        }
        if (isset($input['text_button_submit'])) {
            $sanitized['text_button_submit'] = sanitize_text_field($input['text_button_submit']);
        }

        return $sanitized;
    }
}
