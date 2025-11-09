<?php
/**
 * Gestionnaire des emails
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Email_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_email_templates_menu'), 12);
        add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
        add_action('wp_ajax_cf_send_test_email', array($this, 'ajax_send_test_email'));
    }

    /**
     * Ajoute le menu des templates d'emails
     */
    public function add_email_templates_menu() {
        add_submenu_page(
            'cf-agenda',
            __('Templates d\'emails', 'calendrier-formation'),
            __('Templates emails', 'calendrier-formation'),
            'manage_options',
            'cf-email-templates',
            array($this, 'render_email_templates_page')
        );
    }

    /**
     * Configure le type de contenu HTML pour les emails
     */
    public function set_html_content_type() {
        return 'text/html';
    }

    /**
     * Affiche la page des templates d'emails
     */
    public function render_email_templates_page() {
        global $wpdb;
        $table_templates = $wpdb->prefix . 'cf_email_templates';

        // Gestion des actions
        if (isset($_POST['cf_save_template']) && check_admin_referer('cf_save_template')) {
            $template_id = intval($_POST['template_id']);
            $data = array(
                'subject' => sanitize_text_field($_POST['subject']),
                'body' => wp_kses_post($_POST['body']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            );

            $wpdb->update($table_templates, $data, array('id' => $template_id));
            echo '<div class="notice notice-success"><p>' . __('Template enregistré avec succès', 'calendrier-formation') . '</p></div>';
        }

        // Récupérer tous les templates
        $templates = $wpdb->get_results("SELECT * FROM $table_templates ORDER BY template_name ASC");

        // Template à éditer
        $edit_template = null;
        if (isset($_GET['edit'])) {
            $edit_id = intval($_GET['edit']);
            $edit_template = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_templates WHERE id = %d", $edit_id));
        }

        // Charger le template
        include CF_PLUGIN_DIR . 'templates/admin-email-templates.php';
    }

    /**
     * Récupère un template par sa clé
     */
    public function get_template($template_key) {
        global $wpdb;
        $table_templates = $wpdb->prefix . 'cf_email_templates';

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_templates WHERE template_key = %s AND is_active = 1",
            $template_key
        ));
    }

    /**
     * Remplace les variables dans un template
     */
    private function replace_variables($content, $variables) {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }

    /**
     * Prépare les variables pour une réservation
     */
    private function prepare_booking_variables($booking) {
        $date_debut = new DateTime($booking->date_debut);
        $date_fin = new DateTime($booking->date_fin);

        $localisation = $booking->type_location === 'distance'
            ? __('À distance', 'calendrier-formation')
            : ($booking->location_details ?: __('En présentiel', 'calendrier-formation'));

        // Adresse complète avec vérification des propriétés
        $adresse_complete = trim(
            ($booking->adresse ?? '') . "\n" .
            ($booking->code_postal ?? '') . ' ' .
            ($booking->ville ?? '') . "\n" .
            ($booking->pays ?? '')
        );

        return array(
            'prenom' => $booking->prenom ?? '',
            'nom' => $booking->nom ?? '',
            'email' => $booking->email ?? '',
            'telephone' => $booking->telephone ?? '',
            'fonction' => $booking->fonction ?? '',
            'civilite' => $booking->civilite ?? '',
            'raison_sociale' => $booking->raison_sociale ?? '',
            'siret' => $booking->siret ?? '',
            'adresse_complete' => $adresse_complete,
            'code_postal' => $booking->code_postal ?? '',
            'ville' => $booking->ville ?? '',
            'pays' => $booking->pays ?? '',
            'secteur_activite' => $booking->secteur_activite ?? '',
            'taille_entreprise' => $booking->taille_entreprise ?? '',
            'formation_title' => $booking->formation_title ?? '',
            'session_title' => $booking->session_title ?? '',
            'date_debut' => $date_debut->format('d/m/Y'),
            'date_fin' => $date_fin->format('d/m/Y'),
            'duree' => $booking->duree ?? '',
            'localisation' => $localisation,
            'nombre_participants' => $booking->nombre_participants ?? 1,
            'besoins_specifiques' => ($booking->besoins_specifiques ?? '') ?: __('Aucun', 'calendrier-formation'),
            'commentaires' => ($booking->commentaires ?? '') ?: __('Aucun', 'calendrier-formation'),
            'booking_key' => $booking->booking_key ?? '',
            'created_at' => date('d/m/Y à H:i', strtotime($booking->created_at)),
            'admin_url' => admin_url('admin.php?page=cf-bookings&view=' . ($booking->id ?? 0)),
            'site_name' => get_bloginfo('name'),
            'site_url' => home_url()
        );
    }

    /**
     * Envoie l'email de confirmation au client
     */
    public function send_booking_confirmation($booking) {
        $template = $this->get_template('booking_confirmation_client');
        if (!$template) {
            return false;
        }

        $variables = $this->prepare_booking_variables($booking);

        $subject = $this->replace_variables($template->subject, $variables);
        $body = $this->replace_variables($template->body, $variables);
        $body = $this->format_email_body($body);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . $this->get_from_email() . '>'
        );

        return wp_mail($booking->email, $subject, $body, $headers);
    }

    /**
     * Envoie la notification à l'admin
     */
    public function send_admin_notification($booking) {
        $template = $this->get_template('booking_notification_admin');
        if (!$template) {
            return false;
        }

        $variables = $this->prepare_booking_variables($booking);

        $subject = $this->replace_variables($template->subject, $variables);
        $body = $this->replace_variables($template->body, $variables);
        $body = $this->format_email_body($body);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: ' . $booking->email
        );

        $admin_email = $this->get_admin_email();

        return wp_mail($admin_email, $subject, $body, $headers);
    }

    /**
     * Envoie l'email de confirmation d'inscription
     */
    public function send_booking_confirmed($booking) {
        $template = $this->get_template('booking_confirmed');
        if (!$template) {
            return false;
        }

        $variables = $this->prepare_booking_variables($booking);

        $subject = $this->replace_variables($template->subject, $variables);
        $body = $this->replace_variables($template->body, $variables);
        $body = $this->format_email_body($body);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . $this->get_from_email() . '>'
        );

        return wp_mail($booking->email, $subject, $body, $headers);
    }

    /**
     * Formate le corps de l'email
     */
    private function format_email_body($body) {
        // Convertir les retours à la ligne en <br>
        $body = nl2br($body);

        // Wrapper HTML
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
        .content { background: #fff; padding: 30px; border: 1px solid #e0e0e0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>' . get_bloginfo('name') . '</h1>
        </div>
        <div class="content">
            ' . $body . '
        </div>
        <div class="footer">
            <p>&copy; ' . date('Y') . ' ' . get_bloginfo('name') . ' - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>';

        return $html;
    }

    /**
     * Récupère l'email de l'expéditeur
     */
    private function get_from_email() {
        $settings = get_option('cf_settings', array());
        return isset($settings['email_admin']) ? $settings['email_admin'] : get_option('admin_email');
    }

    /**
     * Récupère l'email de l'admin
     */
    private function get_admin_email() {
        $settings = get_option('cf_settings', array());
        return isset($settings['email_admin']) ? $settings['email_admin'] : get_option('admin_email');
    }

    /**
     * Envoie un email de test
     */
    public function send_test_email($template_key, $recipient) {
        $template = $this->get_template($template_key);
        if (!$template) {
            return false;
        }

        // Variables de test
        $test_variables = array(
            'prenom' => 'Jean',
            'nom' => 'DUPONT',
            'email' => $recipient,
            'telephone' => '06 12 34 56 78',
            'fonction' => 'Responsable Formation',
            'civilite' => 'M.',
            'raison_sociale' => 'Test Entreprise SARL',
            'siret' => '123 456 789 00012',
            'adresse_complete' => "10 rue de Test\n75001 Paris\nFrance",
            'secteur_activite' => 'Informatique',
            'taille_entreprise' => '10-50',
            'formation_title' => 'Formation WordPress Avancé',
            'session_title' => 'Session Février 2025',
            'date_debut' => '15/02/2025',
            'date_fin' => '17/02/2025',
            'duree' => '3 jours',
            'localisation' => 'Paris - 10 rue de la Formation',
            'nombre_participants' => '2',
            'besoins_specifiques' => 'Accès PMR souhaité',
            'commentaires' => 'Demande de convention de formation',
            'booking_key' => 'TEST-123456',
            'created_at' => date('d/m/Y à H:i'),
            'admin_url' => admin_url('admin.php?page=cf-bookings'),
            'site_name' => get_bloginfo('name'),
            'site_url' => home_url()
        );

        $subject = '[TEST] ' . $this->replace_variables($template->subject, $test_variables);
        $body = $this->replace_variables($template->body, $test_variables);
        $body = $this->format_email_body($body);

        $headers = array('Content-Type: text/html; charset=UTF-8');

        return wp_mail($recipient, $subject, $body, $headers);
    }

    /**
     * AJAX: Envoie un email de test
     */
    public function ajax_send_test_email() {
        check_ajax_referer('cf_test_email', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Permission refusée', 'calendrier-formation')));
        }

        $template_key = sanitize_text_field($_POST['template_key']);
        $email = sanitize_email($_POST['email']);

        if (empty($email)) {
            wp_send_json_error(array('message' => __('Email invalide', 'calendrier-formation')));
        }

        $result = $this->send_test_email($template_key, $email);

        if ($result) {
            wp_send_json_success(array('message' => __('Email de test envoyé', 'calendrier-formation')));
        } else {
            wp_send_json_error(array('message' => __('Erreur lors de l\'envoi', 'calendrier-formation')));
        }
    }
}
