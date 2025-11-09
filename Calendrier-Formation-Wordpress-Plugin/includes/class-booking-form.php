<?php
/**
 * Formulaire de réservation frontend (shortcode)
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Booking_Form {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('formulaire_reservation', array($this, 'render_booking_form'));
        add_action('wp_ajax_cf_submit_booking', array($this, 'ajax_submit_booking'));
        add_action('wp_ajax_nopriv_cf_submit_booking', array($this, 'ajax_submit_booking'));
    }

    /**
     * Rendu du formulaire de réservation
     */
    public function render_booking_form($atts) {
        // Récupérer les paramètres de session depuis l'URL
        $session_id = isset($_GET['session_id']) ? intval($_GET['session_id']) : 0;
        $formation = isset($_GET['formation']) ? sanitize_text_field($_GET['formation']) : '';
        $session = isset($_GET['session']) ? sanitize_text_field($_GET['session']) : '';
        $date_debut = isset($_GET['date_debut']) ? sanitize_text_field($_GET['date_debut']) : '';

        // Si pas de session_id, afficher le catalogue de toutes les sessions
        if (!$session_id) {
            return $this->render_sessions_catalog();
        }

        // Récupérer les informations complètes de la session
        global $wpdb;
        $session_data = $wpdb->get_row($wpdb->prepare(
            "SELECT s.*, p.post_title as formation_title
             FROM {$wpdb->prefix}cf_sessions s
             LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
             WHERE s.id = %d",
            $session_id
        ));

        if (!$session_data) {
            return '<div class="cf-error">' . __('Session introuvable.', 'calendrier-formation') . '</div>';
        }

        wp_enqueue_style('cf-booking-form', CF_PLUGIN_URL . 'assets/css/booking-form.css', array(), CF_VERSION);
        wp_enqueue_script('cf-booking-form', CF_PLUGIN_URL . 'assets/js/booking-form.js', array('jquery'), CF_VERSION, true);

        wp_localize_script('cf-booking-form', 'cfBooking', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cf_booking_nonce'),
            'strings' => array(
                'submitting' => __('Envoi en cours...', 'calendrier-formation'),
                'success' => __('Votre demande a été envoyée avec succès !', 'calendrier-formation'),
                'error' => __('Une erreur est survenue', 'calendrier-formation')
            )
        ));

        ob_start();
        include CF_PLUGIN_DIR . 'templates/booking-form.php';
        return ob_get_clean();
    }

    /**
     * Affiche le catalogue de toutes les sessions disponibles
     */
    private function render_sessions_catalog() {
        global $wpdb;

        // Récupérer toutes les sessions futures groupées par formation
        $sessions = $wpdb->get_results("
            SELECT s.*, p.post_title as formation_title, p.ID as formation_id
            FROM {$wpdb->prefix}cf_sessions s
            LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
            WHERE s.status = 'active' AND s.date_debut >= NOW()
            ORDER BY p.post_title ASC, s.date_debut ASC
        ");

        if (empty($sessions)) {
            return '<div class="cf-no-sessions">' . __('Aucune session disponible pour le moment.', 'calendrier-formation') . '</div>';
        }

        // Grouper par formation
        $formations = array();
        foreach ($sessions as $session) {
            $formation_id = $session->formation_id;
            if (!isset($formations[$formation_id])) {
                $formations[$formation_id] = array(
                    'title' => $session->formation_title,
                    'sessions' => array()
                );
            }
            $formations[$formation_id]['sessions'][] = $session;
        }

        // Charger les styles
        wp_enqueue_style('cf-frontend', CF_PLUGIN_URL . 'assets/css/frontend.css', array(), CF_VERSION);

        ob_start();
        ?>
        <div class="cf-sessions-catalog">
            <div class="cf-catalog-header">
                <h2><?php echo esc_html(CF_Settings::get_setting('text_catalog_title', __('Nos Formations Disponibles', 'calendrier-formation'))); ?></h2>
                <p><?php printf(__('Cliquez sur "%s" pour vous inscrire à une session', 'calendrier-formation'), CF_Settings::get_setting('text_button_reserve', __('Réserver ma place', 'calendrier-formation'))); ?></p>
            </div>

            <?php foreach ($formations as $formation_id => $formation): ?>
                <div class="cf-formation-block">
                    <h3 class="cf-formation-title">
                        <span class="dashicons dashicons-book-alt"></span>
                        <?php echo esc_html($formation['title']); ?>
                    </h3>

                    <div class="cf-sessions-grid">
                        <?php foreach ($formation['sessions'] as $session): ?>
                            <?php $this->render_catalog_session_card($session); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Affiche une carte de session pour le catalogue
     */
    private function render_catalog_session_card($session) {
        $date_debut = new DateTime($session->date_debut);
        $date_fin = new DateTime($session->date_fin);
        $is_full = $session->places_disponibles <= 0;

        // Construire l'URL de réservation (uniquement session_id)
        $current_url = get_permalink();
        $booking_url = add_query_arg(array(
            'session_id' => $session->id
        ), $current_url);

        // Calculer le pourcentage de disponibilité
        $availability_percentage = ($session->places_total > 0)
            ? round(($session->places_disponibles / $session->places_total) * 100)
            : 0;

        $status_class = 'cf-status-green';
        if ($availability_percentage < 30) {
            $status_class = 'cf-status-red';
        } elseif ($availability_percentage < 70) {
            $status_class = 'cf-status-orange';
        }
        ?>
        <div class="cf-session-card <?php echo $is_full ? 'cf-session-full' : ''; ?>">
            <div class="cf-session-card-header">
                <h4 class="cf-session-card-title"><?php echo esc_html($session->session_title); ?></h4>
                <?php if ($is_full): ?>
                    <span class="cf-badge cf-badge-full"><?php _e('Complet', 'calendrier-formation'); ?></span>
                <?php elseif ($session->places_disponibles <= 3): ?>
                    <span class="cf-badge cf-badge-warning"><?php _e('Places limitées', 'calendrier-formation'); ?></span>
                <?php else: ?>
                    <span class="cf-badge cf-badge-available"><?php _e('Places disponibles', 'calendrier-formation'); ?></span>
                <?php endif; ?>
            </div>

            <div class="cf-session-card-body">
                <div class="cf-session-info-grid">
                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-calendar"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Du', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value"><?php echo esc_html($date_debut->format('d/m/Y')); ?></div>
                        </div>
                    </div>

                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-calendar"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Au', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value"><?php echo esc_html($date_fin->format('d/m/Y')); ?></div>
                        </div>
                    </div>

                    <?php if (!empty($session->duree)): ?>
                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-clock"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Durée', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value"><?php echo esc_html($session->duree); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="cf-session-info-item">
                        <span class="cf-info-icon dashicons dashicons-location"></span>
                        <div class="cf-info-content">
                            <div class="cf-info-label"><?php _e('Localisation', 'calendrier-formation'); ?></div>
                            <div class="cf-info-value">
                                <?php if ($session->type_location === 'distance'): ?>
                                    <?php _e('À distance', 'calendrier-formation'); ?>
                                <?php else: ?>
                                    <?php echo esc_html($session->location_details ? $session->location_details : __('En présentiel', 'calendrier-formation')); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cf-session-places">
                    <div class="cf-places-header">
                        <span class="cf-places-label"><?php _e('Places disponibles', 'calendrier-formation'); ?></span>
                        <span class="cf-places-count <?php echo esc_attr($status_class); ?>">
                            <strong><?php echo esc_html($session->places_disponibles); ?></strong> / <?php echo esc_html($session->places_total); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="cf-session-card-footer">
                <?php if ($is_full): ?>
                    <button class="cf-btn cf-btn-disabled" disabled>
                        <?php _e('Session complète', 'calendrier-formation'); ?>
                    </button>
                <?php else: ?>
                    <a href="<?php echo esc_url($booking_url); ?>" class="cf-btn cf-btn-primary">
                        <?php echo esc_html(CF_Settings::get_setting('text_button_reserve', __('Réserver ma place', 'calendrier-formation'))); ?>
                        <span class="dashicons dashicons-arrow-right-alt"></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Traite la soumission du formulaire
     */
    public function ajax_submit_booking() {
        // Vérifier le nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cf_booking_nonce')) {
            wp_send_json_error(array('message' => __('Sécurité : nonce invalide', 'calendrier-formation')));
            exit;
        }

        // Valider les champs obligatoires
        $required_fields = array('session_id', 'nom', 'prenom', 'email');
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                wp_send_json_error(array('message' => sprintf(__('Le champ %s est obligatoire', 'calendrier-formation'), $field)));
                exit;
            }
        }

        // Créer la réservation
        $result = CF_Bookings_Manager::get_instance()->create_booking($_POST);

        if ($result['success']) {
            wp_send_json_success(array(
                'message' => __('Votre demande d\'inscription a été envoyée avec succès ! Vous allez recevoir un email de confirmation.', 'calendrier-formation'),
                'booking_key' => $result['booking_key']
            ));
        } else {
            wp_send_json_error(array('message' => $result['message']));
        }

        exit;
    }
}
