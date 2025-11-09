<?php
/**
 * Gestion des réservations
 */

if (!defined('ABSPATH')) {
    exit;
}

class CF_Booking_Handler {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_bookings_page'));
        add_action('wp_ajax_cf_update_booking_status', array($this, 'ajax_update_booking_status'));
        add_action('wp_ajax_cf_delete_booking', array($this, 'ajax_delete_booking'));
    }

    /**
     * Ajoute la page de gestion des réservations
     */
    public function add_bookings_page() {
        add_submenu_page(
            'edit.php?post_type=formation',
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
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';
        $table_sessions = $wpdb->prefix . 'cf_sessions';

        // Récupérer les réservations avec les informations de session
        $bookings = $wpdb->get_results("
            SELECT
                b.*,
                s.session_title,
                s.date_debut,
                s.post_id,
                p.post_title as formation_title
            FROM $table_bookings b
            LEFT JOIN $table_sessions s ON b.session_id = s.id
            LEFT JOIN {$wpdb->posts} p ON s.post_id = p.ID
            ORDER BY b.created_at DESC
        ");

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Réservations de formation', 'calendrier-formation'); ?></h1>

            <?php if (empty($bookings)): ?>
                <div class="notice notice-info">
                    <p><?php _e('Aucune réservation pour le moment.', 'calendrier-formation'); ?></p>
                </div>
            <?php else: ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php _e('ID', 'calendrier-formation'); ?></th>
                            <th><?php _e('Formation', 'calendrier-formation'); ?></th>
                            <th><?php _e('Session', 'calendrier-formation'); ?></th>
                            <th><?php _e('Participant', 'calendrier-formation'); ?></th>
                            <th><?php _e('Contact', 'calendrier-formation'); ?></th>
                            <th><?php _e('Date réservation', 'calendrier-formation'); ?></th>
                            <th><?php _e('Statut', 'calendrier-formation'); ?></th>
                            <th><?php _e('Actions', 'calendrier-formation'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr data-booking-id="<?php echo esc_attr($booking->id); ?>">
                                <td><?php echo esc_html($booking->id); ?></td>
                                <td>
                                    <strong><?php echo esc_html($booking->formation_title); ?></strong>
                                    <?php if ($booking->post_id): ?>
                                        <br><small><a href="<?php echo get_permalink($booking->post_id); ?>" target="_blank"><?php _e('Voir la page', 'calendrier-formation'); ?></a></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo esc_html($booking->session_title); ?>
                                    <?php if ($booking->date_debut): ?>
                                        <br><small><?php echo esc_html(date('d/m/Y H:i', strtotime($booking->date_debut))); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo esc_html($booking->prenom . ' ' . $booking->nom); ?></strong>
                                    <?php if ($booking->entreprise): ?>
                                        <br><small><?php echo esc_html($booking->entreprise); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="mailto:<?php echo esc_attr($booking->email); ?>"><?php echo esc_html($booking->email); ?></a>
                                    <?php if ($booking->telephone): ?>
                                        <br><small><?php echo esc_html($booking->telephone); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html(date('d/m/Y H:i', strtotime($booking->created_at))); ?></td>
                                <td class="cf-status-cell">
                                    <?php $this->render_status_select($booking); ?>
                                </td>
                                <td>
                                    <button class="button cf-delete-booking" data-booking-id="<?php echo esc_attr($booking->id); ?>">
                                        <?php _e('Supprimer', 'calendrier-formation'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <style>
            .cf-status-select {
                padding: 5px;
                border-radius: 3px;
            }
            .cf-status-pending {
                background-color: #f0ad4e;
                color: white;
            }
            .cf-status-confirmed {
                background-color: #5cb85c;
                color: white;
            }
            .cf-status-cancelled {
                background-color: #d9534f;
                color: white;
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            // Mise à jour du statut
            $(document).on('change', '.cf-status-select', function() {
                var $select = $(this);
                var bookingId = $select.data('booking-id');
                var newStatus = $select.val();

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'cf_update_booking_status',
                        booking_id: bookingId,
                        status: newStatus,
                        nonce: '<?php echo wp_create_nonce('cf_update_booking_status'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Mise à jour de la classe CSS
                            $select.removeClass('cf-status-pending cf-status-confirmed cf-status-cancelled');
                            $select.addClass('cf-status-' + newStatus);
                        } else {
                            alert('<?php _e('Erreur lors de la mise à jour', 'calendrier-formation'); ?>');
                        }
                    }
                });
            });

            // Suppression d'une réservation
            $(document).on('click', '.cf-delete-booking', function() {
                if (!confirm('<?php _e('Êtes-vous sûr de vouloir supprimer cette réservation ?', 'calendrier-formation'); ?>')) {
                    return;
                }

                var $btn = $(this);
                var bookingId = $btn.data('booking-id');
                var $row = $btn.closest('tr');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'cf_delete_booking',
                        booking_id: bookingId,
                        nonce: '<?php echo wp_create_nonce('cf_delete_booking'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $row.fadeOut(function() {
                                $(this).remove();
                            });
                        } else {
                            alert('<?php _e('Erreur lors de la suppression', 'calendrier-formation'); ?>');
                        }
                    }
                });
            });
        });
        </script>
        <?php
    }

    /**
     * Affiche le sélecteur de statut
     */
    private function render_status_select($booking) {
        $statuses = array(
            'pending' => __('En attente', 'calendrier-formation'),
            'confirmed' => __('Confirmée', 'calendrier-formation'),
            'cancelled' => __('Annulée', 'calendrier-formation'),
        );

        echo '<select class="cf-status-select cf-status-' . esc_attr($booking->status) . '" data-booking-id="' . esc_attr($booking->id) . '">';
        foreach ($statuses as $value => $label) {
            $selected = ($value === $booking->status) ? 'selected' : '';
            echo '<option value="' . esc_attr($value) . '" ' . $selected . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }

    /**
     * AJAX: Mise à jour du statut
     */
    public function ajax_update_booking_status() {
        check_ajax_referer('cf_update_booking_status', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }

        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        $booking_id = intval($_POST['booking_id']);
        $status = sanitize_text_field($_POST['status']);

        $result = $wpdb->update(
            $table_bookings,
            array('status' => $status),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );

        if ($result !== false) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => 'Failed to update status'));
        }
    }

    /**
     * AJAX: Suppression d'une réservation
     */
    public function ajax_delete_booking() {
        check_ajax_referer('cf_delete_booking', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }

        global $wpdb;
        $table_bookings = $wpdb->prefix . 'cf_bookings';

        $booking_id = intval($_POST['booking_id']);

        $result = $wpdb->delete($table_bookings, array('id' => $booking_id), array('%d'));

        if ($result) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => 'Failed to delete booking'));
        }
    }
}
