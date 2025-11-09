<?php
/**
 * Plugin Name: Calendrier Formation
 * Plugin URI: https://github.com/ylureault/Calendrier-Formation-Wordpress-Plugin
 * Description: Interface professionnelle de gestion d'agenda pour vos formations avec vue calendrier, planning et réservations
 * Version: 2.0.0
 * Author: Votre Nom
 * Author URI: https://github.com/ylureault
 * License: GPL v2 or later
 * Text Domain: calendrier-formation
 * Domain Path: /languages
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('CF_VERSION', '2.0.0');
define('CF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CF_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CF_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Classe principale du plugin
 */
class Calendrier_Formation {

    /**
     * Instance unique du plugin (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique du plugin
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur privé (Singleton)
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Charge les fichiers nécessaires
     */
    private function load_dependencies() {
        require_once CF_PLUGIN_DIR . 'includes/class-formations-scanner.php';
        require_once CF_PLUGIN_DIR . 'includes/class-agenda-menu.php';
        require_once CF_PLUGIN_DIR . 'includes/class-calendar-view.php';
        require_once CF_PLUGIN_DIR . 'includes/class-sessions-manager.php';
        require_once CF_PLUGIN_DIR . 'includes/class-settings.php';
        require_once CF_PLUGIN_DIR . 'includes/class-shortcode.php';
        require_once CF_PLUGIN_DIR . 'includes/class-bookings-manager.php';
        require_once CF_PLUGIN_DIR . 'includes/class-email-manager.php';
        require_once CF_PLUGIN_DIR . 'includes/class-booking-form.php';
        require_once CF_PLUGIN_DIR . 'includes/class-ajax-handler.php';
        require_once CF_PLUGIN_DIR . 'includes/class-diagnostic-404.php';
    }

    /**
     * Initialise les hooks
     */
    private function init_hooks() {
        // Activation et désactivation
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Initialisation
        add_action('init', array($this, 'init'));

        // Scripts et styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Initialisation du plugin
     */
    public function init() {
        // Charger la traduction
        load_plugin_textdomain('calendrier-formation', false, dirname(CF_PLUGIN_BASENAME) . '/languages');

        // Initialiser les composants
        CF_Formations_Scanner::get_instance();
        CF_Agenda_Menu::get_instance();
        CF_Calendar_View::get_instance();
        CF_Sessions_Manager::get_instance();
        CF_Settings::get_instance();
        CF_Shortcode::get_instance();
        CF_Bookings_Manager::get_instance();
        CF_Email_Manager::get_instance();
        CF_Booking_Form::get_instance();
        CF_Ajax_Handler::get_instance();
        CF_Diagnostic_404::get_instance();
    }

    /**
     * Activation du plugin
     */
    public function activate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'cf_sessions';

        // Création de la table pour les sessions
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            post_id bigint(20) NOT NULL,
            session_title varchar(255) NOT NULL,
            date_debut datetime NOT NULL,
            date_fin datetime NOT NULL,
            duree varchar(100) DEFAULT '',
            type_location varchar(50) DEFAULT 'distance',
            location_details text,
            places_total int(11) DEFAULT 0,
            places_disponibles int(11) DEFAULT 0,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY post_id (post_id),
            KEY date_debut (date_debut),
            KEY status (status)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Table pour les réservations
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        $sql_bookings = "CREATE TABLE IF NOT EXISTS $table_bookings (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            session_id bigint(20) NOT NULL,

            -- Informations personnelles
            civilite varchar(10) DEFAULT '',
            nom varchar(255) NOT NULL,
            prenom varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            telephone varchar(50) DEFAULT '',
            fonction varchar(255) DEFAULT '',

            -- Informations entreprise
            raison_sociale varchar(255) DEFAULT '',
            siret varchar(50) DEFAULT '',
            adresse text,
            code_postal varchar(10) DEFAULT '',
            ville varchar(255) DEFAULT '',
            pays varchar(100) DEFAULT 'France',
            secteur_activite varchar(255) DEFAULT '',
            taille_entreprise varchar(50) DEFAULT '',

            -- Détails réservation
            nombre_participants int(11) DEFAULT 1,
            besoins_specifiques text,
            commentaires text,
            type_facturation varchar(50) DEFAULT '',

            -- Métadonnées
            status varchar(20) DEFAULT 'pending',
            booking_key varchar(100) NOT NULL,
            ip_address varchar(100) DEFAULT '',
            user_agent text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            PRIMARY KEY  (id),
            KEY session_id (session_id),
            KEY booking_key (booking_key),
            KEY email (email),
            KEY status (status)
        ) $charset_collate;";

        dbDelta($sql_bookings);

        // Table pour les templates d'emails
        $table_email_templates = $wpdb->prefix . 'cf_email_templates';

        $sql_email_templates = "CREATE TABLE IF NOT EXISTS $table_email_templates (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            template_key varchar(50) NOT NULL,
            template_name varchar(255) NOT NULL,
            subject varchar(500) NOT NULL,
            body longtext NOT NULL,
            variables text,
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            UNIQUE KEY template_key (template_key)
        ) $charset_collate;";

        dbDelta($sql_email_templates);

        // Insérer les templates par défaut
        $existing_templates = $wpdb->get_var("SELECT COUNT(*) FROM $table_email_templates");
        if ($existing_templates == 0) {
            $default_templates = array(
                array(
                    'template_key' => 'booking_confirmation_client',
                    'template_name' => 'Confirmation de réservation - Client',
                    'subject' => 'Confirmation de votre inscription à la formation {{formation_title}}',
                    'body' => "Bonjour {{prenom}} {{nom}},\n\nNous confirmons votre demande d'inscription à la formation suivante :\n\n📚 Formation : {{formation_title}}\n🗓️ Session : {{session_title}}\n📅 Date de début : {{date_debut}}\n📅 Date de fin : {{date_fin}}\n⏱️ Durée : {{duree}}\n📍 Localisation : {{localisation}}\n\nDétails de votre réservation :\n- Nombre de participants : {{nombre_participants}}\n- Référence : {{booking_key}}\n\nNous reviendrons vers vous très prochainement pour confirmer votre inscription et vous transmettre les détails pratiques.\n\nCordialement,\nL'équipe formation",
                    'variables' => 'prenom,nom,email,formation_title,session_title,date_debut,date_fin,duree,localisation,nombre_participants,booking_key'
                ),
                array(
                    'template_key' => 'booking_notification_admin',
                    'template_name' => 'Nouvelle réservation - Admin',
                    'subject' => 'Nouvelle demande d\'inscription - {{formation_title}}',
                    'body' => "Une nouvelle demande d'inscription a été reçue.\n\n=== FORMATION ===\nFormation : {{formation_title}}\nSession : {{session_title}}\nDates : du {{date_debut}} au {{date_fin}}\n\n=== PARTICIPANT ===\nNom : {{prenom}} {{nom}}\nEmail : {{email}}\nTéléphone : {{telephone}}\nFonction : {{fonction}}\n\n=== ENTREPRISE ===\nRaison sociale : {{raison_sociale}}\nSIRET : {{siret}}\nAdresse : {{adresse_complete}}\nSecteur : {{secteur_activite}}\n\n=== DÉTAILS ===\nNombre de participants : {{nombre_participants}}\nBesoins spécifiques : {{besoins_specifiques}}\nCommentaires : {{commentaires}}\n\nRéférence : {{booking_key}}\nDate de la demande : {{created_at}}\n\nAccéder à la réservation : {{admin_url}}",
                    'variables' => 'prenom,nom,email,telephone,fonction,raison_sociale,siret,adresse_complete,secteur_activite,formation_title,session_title,date_debut,date_fin,duree,nombre_participants,besoins_specifiques,commentaires,booking_key,created_at,admin_url'
                ),
                array(
                    'template_key' => 'booking_confirmed',
                    'template_name' => 'Réservation confirmée - Client',
                    'subject' => 'Votre inscription est confirmée - {{formation_title}}',
                    'body' => "Bonjour {{prenom}} {{nom}},\n\nNous avons le plaisir de vous confirmer votre inscription à la formation :\n\n📚 Formation : {{formation_title}}\n🗓️ Session : {{session_title}}\n📅 Date de début : {{date_debut}}\n📅 Date de fin : {{date_fin}}\n📍 Localisation : {{localisation}}\n\nVous recevrez prochainement :\n✅ Les informations de connexion (si formation à distance)\n✅ Les modalités pratiques\n✅ Le programme détaillé\n✅ La convention de formation\n\nNombre de participants confirmés : {{nombre_participants}}\n\nÀ très bientôt !\n\nCordialement,\nL'équipe formation",
                    'variables' => 'prenom,nom,email,formation_title,session_title,date_debut,date_fin,localisation,nombre_participants'
                )
            );

            foreach ($default_templates as $template) {
                $wpdb->insert($table_email_templates, $template);
            }
        }

        // Créer les options par défaut
        $existing_settings = get_option('cf_settings');
        if (!$existing_settings) {
            // Créer la page d'inscription automatiquement
            $inscription_page = array(
                'post_title'    => 'Inscription Formation',
                'post_content'  => '[formulaire_reservation]',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_author'   => 1,
                'comment_status' => 'closed',
                'ping_status'   => 'closed'
            );

            $inscription_page_id = wp_insert_post($inscription_page);

            add_option('cf_settings', array(
                'formations_parent_id' => 51,
                'inscription_page_id' => $inscription_page_id,
                'contact_page_id' => 0,
                'form_url' => '',
                'email_admin' => get_option('admin_email'),
                'calendar_view' => 'month',
                'default_session_duration' => 7
            ));
        }
    }

    /**
     * Désactivation du plugin
     */
    public function deactivate() {
        // Rien à faire pour le moment
    }

    /**
     * Enregistre les assets frontend
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'cf-frontend',
            CF_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            CF_VERSION
        );

        wp_enqueue_script(
            'cf-frontend',
            CF_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            CF_VERSION,
            true
        );
    }

    /**
     * Enregistre les assets admin
     */
    public function enqueue_admin_assets($hook) {
        // Charger uniquement sur les pages du plugin
        if (strpos($hook, 'calendrier-formation') === false && strpos($hook, 'cf-') === false) {
            return;
        }

        // FullCalendar CSS et JS
        wp_enqueue_style(
            'fullcalendar',
            'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css',
            array(),
            '6.1.10'
        );

        wp_enqueue_style(
            'cf-admin',
            CF_PLUGIN_URL . 'assets/css/admin-app.css',
            array('fullcalendar'),
            CF_VERSION
        );

        wp_enqueue_script(
            'fullcalendar',
            'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js',
            array(),
            '6.1.10',
            true
        );

        wp_enqueue_script(
            'cf-admin',
            CF_PLUGIN_URL . 'assets/js/admin-app.js',
            array('jquery', 'fullcalendar'),
            CF_VERSION,
            true
        );

        // Localisation
        wp_localize_script('cf-admin', 'cfAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cf_admin_nonce'),
            'strings' => array(
                'confirmDelete' => __('Êtes-vous sûr de vouloir supprimer cette session ?', 'calendrier-formation'),
                'error' => __('Une erreur est survenue', 'calendrier-formation'),
                'success' => __('Opération réussie', 'calendrier-formation'),
            )
        ));
    }
}

/**
 * Fonction principale pour accéder à l'instance du plugin
 */
function calendrier_formation() {
    return Calendrier_Formation::get_instance();
}

// Lancer le plugin
calendrier_formation();
