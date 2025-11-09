<?php
/**
 * Gestionnaire des réservations
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Bookings_Manager {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_bookings_menu'), 11);
        add_action('admin_init', array($this, 'handle_admin_actions'));

        // AJAX handlers
        add_action('wp_ajax_cf_get_booking_details', array($this, 'ajax_get_booking_details'));
        add_action('wp_ajax_cf_send_booking_email', array($this, 'ajax_send_booking_email'));
    }

    /**
     * Gère les actions admin (export, etc.)
     */
    public function handle_admin_actions() {
        if (isset($_GET['page']) && $_GET['page'] === 'cf-bookings' && isset($_GET['action'])) {
            if ($_GET['action'] === 'export_csv' && current_user_can('manage_options')) {
                $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
                $this->export_bookings_csv($status);
            }
        }
    }

    /**
     * Ajoute le menu des réservations
     */
    public function add_bookings_menu() {
        add_submenu_page(
            'cf-agenda',
            __('Réservations', 'calendrier-formation'),
            __('Réservations', 'calendrier-formation'),
            'manage_options',
            'cf-bookings',
            array($this, 'render_bookings_page')
        );
    }

    /**
     * Affiche la page des réservations
     */
    public function render_bookings_page() {
        // Récupérer les statistiques
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        // Filtres
        $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

        // Query
        $query = "SELECT b.*, s.session_title, s.date_debut, s.date_fin,
                  p.post_title as formation_title
                  FROM $table_bookings b
                  LEFT JOIN {$wpdb->prefix}cf_sessions s ON b.session_id = s.id
                  LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
                  WHERE 1=1";

        if ($status_filter !== 'all') {
            $query .= $wpdb->prepare(" AND b.status = %s", $status_filter);
        }

        if (!empty($search)) {
            $query .= $wpdb->prepare(" AND (b.nom LIKE %s OR b.prenom LIKE %s OR b.email LIKE %s OR b.raison_sociale LIKE %s)",
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%'
            );
        }

        $query .= " ORDER BY b.created_at DESC";

        $bookings = $wpdb->get_results($query);

        // Statistiques
        $stats = array(
            'total' => $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings"),
            'pending' => $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings WHERE status = 'pending'"),
            'confirmed' => $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings WHERE status = 'confirmed'"),
            'cancelled' => $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings WHERE status = 'cancelled'")
        );

        // Charger le template
        include CF_PLUGIN_DIR . 'templates/admin-bookings.php';
    }

    /**
     * Récupère une réservation par ID
     */
    public function get_booking($booking_id) {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        return $wpdb->get_row($wpdb->prepare(
            "SELECT b.*, s.session_title, s.date_debut, s.date_fin, s.duree, s.type_location, s.location_details,
             p.post_title as formation_title
             FROM $table_bookings b
             LEFT JOIN {$wpdb->prefix}cf_sessions s ON b.session_id = s.id
             LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
             WHERE b.id = %d",
            $booking_id
        ));
    }

    /**
     * Met à jour le statut d'une réservation
     */
    public function update_booking_status($booking_id, $new_status) {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        $result = $wpdb->update(
            $table_bookings,
            array('status' => $new_status),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );

        if ($result !== false) {
            // Envoyer un email si confirmé
            if ($new_status === 'confirmed') {
                $booking = $this->get_booking($booking_id);
                CF_Email_Manager::get_instance()->send_booking_confirmed($booking);
            }

            return true;
        }

        return false;
    }

    /**
     * Supprime une réservation
     */
    public function delete_booking($booking_id) {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        return $wpdb->delete($table_bookings, array('id' => $booking_id), array('%d'));
    }

    /**
     * Crée une nouvelle réservation
     */
    public function create_booking($data) {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        // Générer une clé unique
        $booking_key = $this->generate_booking_key();

        // Récupérer les colonnes disponibles dans la table
        $available_columns = $this->get_table_columns($table_bookings);

        // Préparer TOUTES les données (liste complète)
        $all_booking_data = array(
            'session_id' => intval($data['session_id']),
            'civilite' => sanitize_text_field($data['civilite'] ?? ''),
            'nom' => sanitize_text_field($data['nom']),
            'prenom' => sanitize_text_field($data['prenom']),
            'email' => sanitize_email($data['email']),
            'telephone' => sanitize_text_field($data['telephone'] ?? ''),
            'fonction' => sanitize_text_field($data['fonction'] ?? ''),
            'raison_sociale' => sanitize_text_field($data['raison_sociale'] ?? ''),
            'siret' => sanitize_text_field($data['siret'] ?? ''),
            'adresse' => sanitize_textarea_field($data['adresse'] ?? ''),
            'code_postal' => sanitize_text_field($data['code_postal'] ?? ''),
            'ville' => sanitize_text_field($data['ville'] ?? ''),
            'pays' => sanitize_text_field($data['pays'] ?? 'France'),
            'secteur_activite' => sanitize_text_field($data['secteur_activite'] ?? ''),
            'taille_entreprise' => sanitize_text_field($data['taille_entreprise'] ?? ''),
            'nombre_participants' => intval($data['nombre_participants'] ?? 1),
            'besoins_specifiques' => sanitize_textarea_field($data['besoins_specifiques'] ?? ''),
            'commentaires' => sanitize_textarea_field($data['commentaires'] ?? ''),
            'type_facturation' => sanitize_text_field($data['type_facturation'] ?? ''),
            'status' => 'pending',
            'booking_key' => $booking_key,
            'ip_address' => $this->get_client_ip(),
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? '')
        );

        // FILTRER pour ne garder QUE les colonnes qui existent vraiment dans la table
        $booking_data = array();
        foreach ($all_booking_data as $column => $value) {
            if (in_array($column, $available_columns)) {
                $booking_data[$column] = $value;
            }
        }

        // Si des colonnes sont manquantes, les logger (en développement)
        $missing_columns = array_diff(array_keys($all_booking_data), $available_columns);
        if (!empty($missing_columns) && defined('WP_DEBUG') && WP_DEBUG) {
            error_log('CF Warning: Colonnes manquantes dans ' . $table_bookings . ': ' . implode(', ', $missing_columns));
        }

        $result = $wpdb->insert($table_bookings, $booking_data);

        if ($result) {
            $booking_id = $wpdb->insert_id;

            // Récupérer les infos complètes de la réservation
            $booking = $this->get_booking($booking_id);

            if ($booking) {
                // Envoyer les emails
                CF_Email_Manager::get_instance()->send_booking_confirmation($booking);
                CF_Email_Manager::get_instance()->send_admin_notification($booking);
            }

            return array(
                'success' => true,
                'booking_id' => $booking_id,
                'booking_key' => $booking_key
            );
        }

        // DEBUG COMPLET : Retourner toutes les informations d'erreur
        $debug_info = array();

        // Erreur SQL
        if ($wpdb->last_error) {
            $debug_info[] = "SQL Error: " . $wpdb->last_error;
        }

        // Dernière requête exécutée
        if ($wpdb->last_query) {
            $debug_info[] = "Last Query: " . $wpdb->last_query;
        }

        // Vérifier si la table existe
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_bookings'");
        if (!$table_exists) {
            $debug_info[] = "ERREUR CRITIQUE: La table $table_bookings n'existe pas !";
        }

        // Lister les colonnes de la table
        $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_bookings");
        $column_names = array();
        if ($columns) {
            foreach ($columns as $column) {
                $column_names[] = $column->Field;
            }
            $debug_info[] = "Colonnes disponibles: " . implode(', ', $column_names);
        }

        // Lister les colonnes qu'on essaie d'insérer
        $debug_info[] = "Colonnes envoyées: " . implode(', ', array_keys($booking_data));

        // Message final
        $error_message = !empty($debug_info)
            ? implode(' | ', $debug_info)
            : __('Erreur inconnue lors de la création de la réservation', 'calendrier-formation');

        return array(
            'success' => false,
            'message' => $error_message
        );
    }

    /**
     * Récupère les colonnes disponibles dans une table
     */
    private function get_table_columns($table_name) {
        global $wpdb;

        $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_name");
        $column_names = array();

        if ($columns) {
            foreach ($columns as $column) {
                $column_names[] = $column->Field;
            }
        }

        return $column_names;
    }

    /**
     * Génère une clé unique pour la réservation
     */
    private function generate_booking_key() {
        return 'CF-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 10));
    }

    /**
     * Récupère l'IP du client
     */
    private function get_client_ip() {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        }
        return sanitize_text_field($ip);
    }

    /**
     * Exporte les réservations en CSV
     */
    public function export_bookings_csv($status = 'all') {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        $query = "SELECT b.*, s.session_title, s.date_debut, s.date_fin, p.post_title as formation_title
                  FROM $table_bookings b
                  LEFT JOIN {$wpdb->prefix}cf_sessions s ON b.session_id = s.id
                  LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID";

        if ($status !== 'all') {
            $query .= $wpdb->prepare(" WHERE b.status = %s", $status);
        }

        $query .= " ORDER BY b.created_at DESC";

        $bookings = $wpdb->get_results($query, ARRAY_A);

        // Générer le CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reservations-' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');

        // En-têtes
        fputcsv($output, array(
            'ID', 'Référence', 'Date demande', 'Statut', 'Formation', 'Session',
            'Date début', 'Civilité', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Fonction',
            'Entreprise', 'SIRET', 'Adresse', 'Code postal', 'Ville',
            'Secteur', 'Taille', 'Participants', 'Besoins', 'Commentaires'
        ));

        // Données
        foreach ($bookings as $booking) {
            fputcsv($output, array(
                $booking['id'],
                $booking['booking_key'],
                $booking['created_at'],
                $booking['status'],
                $booking['formation_title'],
                $booking['session_title'],
                $booking['date_debut'],
                $booking['civilite'],
                $booking['prenom'],
                $booking['nom'],
                $booking['email'],
                $booking['telephone'],
                $booking['fonction'],
                $booking['raison_sociale'],
                $booking['siret'],
                $booking['adresse'],
                $booking['code_postal'],
                $booking['ville'],
                $booking['secteur_activite'],
                $booking['taille_entreprise'],
                $booking['nombre_participants'],
                $booking['besoins_specifiques'],
                $booking['commentaires']
            ));
        }

        fclose($output);
        exit;
    }

    /**
     * AJAX: Récupérer les détails d'une réservation
     */
    public function ajax_get_booking_details() {
        check_ajax_referer('cf_booking_details', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Accès refusé'));
        }

        $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;

        if (!$booking_id) {
            wp_send_json_error(array('message' => 'ID de réservation invalide'));
        }

        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        // Récupérer toutes les données avec une requête plus robuste
        $booking = $wpdb->get_row($wpdb->prepare("
            SELECT b.*,
                   COALESCE(s.session_title, '') as session_title,
                   COALESCE(s.date_debut, '') as date_debut,
                   COALESCE(s.date_fin, '') as date_fin,
                   COALESCE(s.duree, '') as duree,
                   COALESCE(s.lieu, '') as lieu,
                   COALESCE(s.max_participants, 0) as max_participants,
                   COALESCE(p.post_title, '') as formation_title
            FROM $table_bookings b
            LEFT JOIN $table_sessions s ON b.session_id = s.id
            LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
            WHERE b.id = %d
        ", $booking_id));

        if (!$booking) {
            // Log pour débogage
            error_log("CF Debug - Booking not found. ID: $booking_id, Last Error: " . $wpdb->last_error);
            wp_send_json_error(array('message' => 'Réservation introuvable (ID: ' . $booking_id . ')'));
        }

        // Générer le HTML
        ob_start();
        ?>
        <div class="cf-detail-section">
            <h3><span class="dashicons dashicons-admin-users"></span> Informations du participant</h3>
            <div class="cf-detail-grid">
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Civilité:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->civilite ?? ''); ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Nom complet:</div>
                    <div class="cf-detail-value"><strong><?php echo esc_html(($booking->prenom ?? '') . ' ' . ($booking->nom ?? '')); ?></strong></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Email:</div>
                    <div class="cf-detail-value">
                        <a href="mailto:<?php echo esc_attr($booking->email ?? ''); ?>"><?php echo esc_html($booking->email ?? ''); ?></a>
                    </div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Téléphone:</div>
                    <div class="cf-detail-value">
                        <a href="tel:<?php echo esc_attr($booking->telephone ?? ''); ?>"><?php echo esc_html($booking->telephone ?? ''); ?></a>
                    </div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Fonction:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->fonction ?? ''); ?></div>
                </div>
            </div>
        </div>

        <div class="cf-detail-section">
            <h3><span class="dashicons dashicons-building"></span> Informations de l'entreprise</h3>
            <div class="cf-detail-grid">
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Raison sociale:</div>
                    <div class="cf-detail-value"><strong><?php echo esc_html($booking->raison_sociale ?? ''); ?></strong></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">SIRET:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->siret ?? ''); ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Secteur d'activité:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->secteur_activite ?? ''); ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Taille entreprise:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->taille_entreprise ?? ''); ?></div>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Adresse complète:</div>
                    <div class="cf-detail-value">
                        <?php
                        $adresse = trim(
                            ($booking->adresse ?? '') . "\n" .
                            ($booking->code_postal ?? '') . ' ' . ($booking->ville ?? '') . "\n" .
                            ($booking->pays ?? '')
                        );
                        echo nl2br(esc_html($adresse));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="cf-detail-section">
            <h3><span class="dashicons dashicons-calendar-alt"></span> Informations de la formation</h3>
            <div class="cf-detail-grid">
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Formation:</div>
                    <div class="cf-detail-value"><strong><?php echo esc_html($booking->formation_title ?? ''); ?></strong></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Session:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->session_title ?? ''); ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Date début:</div>
                    <div class="cf-detail-value"><?php echo !empty($booking->date_debut) ? date('d/m/Y', strtotime($booking->date_debut)) : 'N/A'; ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Date fin:</div>
                    <div class="cf-detail-value"><?php echo !empty($booking->date_fin) ? date('d/m/Y', strtotime($booking->date_fin)) : 'N/A'; ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Durée:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->duree ?? ''); ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Lieu:</div>
                    <div class="cf-detail-value"><?php echo esc_html($booking->lieu ?? ''); ?></div>
                </div>
                <div class="cf-detail-row">
                    <div class="cf-detail-label">Nombre de participants:</div>
                    <div class="cf-detail-value"><strong><?php echo esc_html($booking->nombre_participants ?? 1); ?></strong></div>
                </div>
            </div>
        </div>

        <div class="cf-detail-section">
            <h3><span class="dashicons dashicons-editor-alignleft"></span> Informations complémentaires</h3>
            <div class="cf-detail-row">
                <div class="cf-detail-label">Besoins spécifiques:</div>
                <div class="cf-detail-value"><?php echo nl2br(esc_html($booking->besoins_specifiques ?? 'Aucun')); ?></div>
            </div>
            <div class="cf-detail-row">
                <div class="cf-detail-label">Commentaires:</div>
                <div class="cf-detail-value"><?php echo nl2br(esc_html($booking->commentaires ?? 'Aucun')); ?></div>
            </div>
            <div class="cf-detail-row">
                <div class="cf-detail-label">Date de réservation:</div>
                <div class="cf-detail-value"><?php echo date('d/m/Y H:i', strtotime($booking->created_at)); ?></div>
            </div>
            <div class="cf-detail-row">
                <div class="cf-detail-label">Statut:</div>
                <div class="cf-detail-value">
                    <?php
                    $status_labels = array(
                        'pending' => '<span class="cf-status-badge cf-status-pending">En attente</span>',
                        'confirmed' => '<span class="cf-status-badge cf-status-confirmed">Confirmée</span>',
                        'cancelled' => '<span class="cf-status-badge cf-status-cancelled">Annulée</span>'
                    );
                    echo $status_labels[$booking->status] ?? $booking->status;
                    ?>
                </div>
            </div>
        </div>

        <!-- Section emails préformatés -->
        <div class="cf-email-section">
            <h3 style="margin-top: 0;"><span class="dashicons dashicons-email"></span> Contacter le participant</h3>
            <p style="margin-bottom: 10px; color: #666;">Envoyez rapidement un email avec un message préformaté:</p>
            <div class="cf-email-templates">
                <button class="cf-email-btn confirm cf-send-email"
                        data-booking-id="<?php echo $booking->id; ?>"
                        data-template="confirm"
                        data-original-text="✓ Confirmer la réservation">
                    <span class="dashicons dashicons-yes"></span>
                    <span>Confirmer la réservation</span>
                </button>
                <button class="cf-email-btn info cf-send-email"
                        data-booking-id="<?php echo $booking->id; ?>"
                        data-template="info"
                        data-original-text="ℹ Demander des informations">
                    <span class="dashicons dashicons-info"></span>
                    <span>Demander des informations</span>
                </button>
                <button class="cf-email-btn reminder cf-send-email"
                        data-booking-id="<?php echo $booking->id; ?>"
                        data-template="reminder"
                        data-original-text="⏰ Envoyer un rappel">
                    <span class="dashicons dashicons-clock"></span>
                    <span>Envoyer un rappel</span>
                </button>
                <button class="cf-email-btn cancel cf-send-email"
                        data-booking-id="<?php echo $booking->id; ?>"
                        data-template="cancel"
                        data-original-text="✗ Annuler la réservation">
                    <span class="dashicons dashicons-no"></span>
                    <span>Annuler la réservation</span>
                </button>
            </div>
        </div>
        <?php
        $html = ob_get_clean();

        wp_send_json_success(array('html' => $html));
    }

    /**
     * AJAX: Envoyer un email avec template préformaté
     */
    public function ajax_send_booking_email() {
        check_ajax_referer('cf_send_email', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Accès refusé'));
        }

        $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
        $template = isset($_POST['template']) ? sanitize_text_field($_POST['template']) : '';

        if (!$booking_id || !$template) {
            wp_send_json_error(array('message' => 'Paramètres invalides'));
        }

        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        $booking = $wpdb->get_row($wpdb->prepare("
            SELECT b.*,
                   COALESCE(s.session_title, '') as session_title,
                   COALESCE(s.date_debut, '') as date_debut,
                   COALESCE(s.date_fin, '') as date_fin,
                   COALESCE(s.lieu, '') as lieu,
                   COALESCE(p.post_title, '') as formation_title
            FROM $table_bookings b
            LEFT JOIN $table_sessions s ON b.session_id = s.id
            LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
            WHERE b.id = %d
        ", $booking_id));

        if (!$booking) {
            error_log("CF Debug - Booking not found for email. ID: $booking_id, Last Error: " . $wpdb->last_error);
            wp_send_json_error(array('message' => 'Réservation introuvable (ID: ' . $booking_id . ')'));
        }

        // Préparer les variables
        $to = $booking->email ?? '';
        $prenom = $booking->prenom ?? '';
        $nom = $booking->nom ?? '';
        $formation = $booking->formation_title ?? '';
        $session = $booking->session_title ?? '';
        $date_debut = !empty($booking->date_debut) ? date('d/m/Y', strtotime($booking->date_debut)) : 'N/A';
        $lieu = $booking->lieu ?? '';

        // Templates d'emails
        $templates = array(
            'confirm' => array(
                'subject' => 'Confirmation de votre inscription - ' . $formation,
                'message' => "Bonjour $prenom $nom,\n\nNous avons le plaisir de confirmer votre inscription à la formation \"$formation\".\n\nDétails de la session:\n- Titre: $session\n- Date de début: $date_debut\n- Lieu: $lieu\n\nNous vous enverrons toutes les informations pratiques dans les prochains jours.\n\nÀ très bientôt !\n\nL'équipe Insuffle Académie"
            ),
            'info' => array(
                'subject' => 'Informations complémentaires nécessaires - ' . $formation,
                'message' => "Bonjour $prenom $nom,\n\nNous avons bien reçu votre demande d'inscription à la formation \"$formation\".\n\nNous aurions besoin de quelques informations complémentaires pour finaliser votre inscription. Pourriez-vous nous recontacter au plus vite ?\n\nMerci de votre collaboration.\n\nCordialement,\nL'équipe Insuffle Académie"
            ),
            'reminder' => array(
                'subject' => 'Rappel - Formation à venir: ' . $formation,
                'message' => "Bonjour $prenom $nom,\n\nNous vous rappelons que votre formation \"$formation\" approche.\n\nDétails:\n- Date: $date_debut\n- Lieu: $lieu\n\nPensez à vous connecter 10 minutes avant le début si la formation est en ligne.\n\nÀ très bientôt !\n\nL'équipe Insuffle Académie"
            ),
            'cancel' => array(
                'subject' => 'Annulation de votre inscription - ' . $formation,
                'message' => "Bonjour $prenom $nom,\n\nNous sommes au regret de vous informer que votre inscription à la formation \"$formation\" (session du $date_debut) a été annulée.\n\nNous vous invitons à nous contacter pour plus d'informations ou pour vous inscrire à une autre session.\n\nToutes nos excuses pour ce désagrément.\n\nCordialement,\nL'équipe Insuffle Académie"
            )
        );

        if (!isset($templates[$template])) {
            wp_send_json_error(array('message' => 'Template invalide'));
        }

        if (empty($to)) {
            wp_send_json_error(array('message' => 'Email du participant non disponible'));
        }

        $email_data = $templates[$template];
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        $sent = wp_mail($to, $email_data['subject'], $email_data['message'], $headers);

        if ($sent) {
            // Mettre à jour le statut si nécessaire
            if ($template === 'confirm') {
                $wpdb->update(
                    $table_bookings,
                    array('status' => 'confirmed'),
                    array('id' => $booking_id),
                    array('%s'),
                    array('%d')
                );
            } elseif ($template === 'cancel') {
                $wpdb->update(
                    $table_bookings,
                    array('status' => 'cancelled'),
                    array('id' => $booking_id),
                    array('%s'),
                    array('%d')
                );
            }

            wp_send_json_success(array('message' => 'Email envoyé avec succès'));
        } else {
            wp_send_json_error(array('message' => 'Erreur lors de l\'envoi de l\'email'));
        }
    }
}
