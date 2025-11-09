<?php
/**
 * EXEMPLE D'INTÉGRATION AVEC UN FORMULAIRE DE CONTACT
 *
 * Ce fichier montre comment récupérer les paramètres de l'URL
 * et pré-remplir automatiquement votre formulaire d'inscription.
 *
 * Vous pouvez utiliser cet exemple avec :
 * - Contact Form 7
 * - Gravity Forms
 * - WPForms
 * - Formidable Forms
 * - Ou votre propre formulaire HTML personnalisé
 */

/**
 * MÉTHODE 1 : Formulaire HTML personnalisé
 * Copiez ce code dans votre page/template
 */
?>

<!-- Exemple de formulaire HTML avec champs pré-remplis -->
<div class="formulaire-inscription">
    <h2>Inscription à la formation</h2>

    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <?php wp_nonce_field('cf_submit_booking', 'cf_booking_nonce'); ?>
        <input type="hidden" name="action" value="cf_submit_booking">

        <!-- Champs cachés avec les infos de la session -->
        <input type="hidden" name="session_id" value="<?php echo esc_attr($_GET['session_id'] ?? ''); ?>">
        <input type="hidden" name="formation_id" value="<?php echo esc_attr($_GET['formation_id'] ?? ''); ?>">
        <input type="hidden" name="booking_key" value="<?php echo esc_attr($_GET['booking_key'] ?? ''); ?>">

        <!-- Informations de la formation (lecture seule) -->
        <div class="form-group">
            <label>Formation :</label>
            <input type="text" readonly value="<?php echo esc_attr($_GET['formation'] ?? ''); ?>" class="form-control-readonly">
        </div>

        <div class="form-group">
            <label>Session :</label>
            <input type="text" readonly value="<?php echo esc_attr($_GET['session'] ?? ''); ?>" class="form-control-readonly">
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Date de début :</label>
                <input type="text" readonly value="<?php echo esc_attr(date('d/m/Y H:i', strtotime($_GET['date_debut'] ?? 'now'))); ?>" class="form-control-readonly">
            </div>
            <div class="form-group col-md-6">
                <label>Date de fin :</label>
                <input type="text" readonly value="<?php echo esc_attr(date('d/m/Y H:i', strtotime($_GET['date_fin'] ?? 'now'))); ?>" class="form-control-readonly">
            </div>
        </div>

        <div class="form-group">
            <label>Durée :</label>
            <input type="text" readonly value="<?php echo esc_attr($_GET['duree'] ?? ''); ?>" class="form-control-readonly">
        </div>

        <div class="form-group">
            <label>Localisation :</label>
            <input type="text" readonly value="<?php
                $type = $_GET['type_location'] ?? 'distance';
                $location = $_GET['location'] ?? '';
                echo esc_attr($type === 'distance' ? 'À distance' : $location);
            ?>" class="form-control-readonly">
        </div>

        <hr>

        <!-- Informations du participant -->
        <h3>Vos informations</h3>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom" required class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" required class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="telephone">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="entreprise">Entreprise</label>
            <input type="text" name="entreprise" id="entreprise" class="form-control">
        </div>

        <div class="form-group">
            <label for="message">Message / Questions</label>
            <textarea name="message" id="message" rows="4" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="accepte_conditions" required>
                J'accepte les conditions générales *
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Confirmer mon inscription</button>
    </form>
</div>

<?php
/**
 * MÉTHODE 2 : Traitement du formulaire
 * Ajoutez ce code dans votre functions.php
 */

// Gérer la soumission du formulaire
add_action('admin_post_cf_submit_booking', 'cf_handle_booking_submission');
add_action('admin_post_nopriv_cf_submit_booking', 'cf_handle_booking_submission');

function cf_handle_booking_submission() {
    // Vérification de sécurité
    if (!isset($_POST['cf_booking_nonce']) || !wp_verify_nonce($_POST['cf_booking_nonce'], 'cf_submit_booking')) {
        wp_die('Erreur de sécurité');
    }

    global $wpdb;
    $table_bookings = $wpdb->prefix . 'cf_bookings';
    $table_sessions = $wpdb->prefix . 'cf_sessions';

    // Récupérer les données
    $session_id = intval($_POST['session_id']);
    $nom = sanitize_text_field($_POST['nom']);
    $prenom = sanitize_text_field($_POST['prenom']);
    $email = sanitize_email($_POST['email']);
    $telephone = sanitize_text_field($_POST['telephone']);
    $entreprise = sanitize_text_field($_POST['entreprise']);
    $message = sanitize_textarea_field($_POST['message']);
    $booking_key = sanitize_text_field($_POST['booking_key']);

    // Vérifier qu'il reste des places
    $session = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_sessions WHERE id = %d",
        $session_id
    ));

    if (!$session || $session->places_disponibles <= 0) {
        wp_redirect(add_query_arg('booking_status', 'full', wp_get_referer()));
        exit;
    }

    // Insérer la réservation
    $result = $wpdb->insert(
        $table_bookings,
        array(
            'session_id' => $session_id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'entreprise' => $entreprise,
            'message' => $message,
            'booking_key' => $booking_key,
            'status' => 'pending',
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result) {
        // Décrémenter les places disponibles
        $wpdb->query($wpdb->prepare(
            "UPDATE $table_sessions SET places_disponibles = places_disponibles - 1 WHERE id = %d",
            $session_id
        ));

        // Envoyer un email de confirmation
        cf_send_booking_confirmation($email, $prenom, $session);

        // Envoyer une notification à l'admin
        cf_send_admin_notification($session_id, $prenom, $nom, $email);

        // Rediriger vers une page de succès
        wp_redirect(add_query_arg('booking_status', 'success', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('booking_status', 'error', wp_get_referer()));
    }
    exit;
}

// Fonction d'envoi d'email de confirmation
function cf_send_booking_confirmation($email, $prenom, $session) {
    $subject = 'Confirmation de votre inscription - ' . $session->session_title;

    $message = "Bonjour $prenom,\n\n";
    $message .= "Nous avons bien reçu votre demande d'inscription pour la session :\n\n";
    $message .= "Formation : " . get_the_title($session->post_id) . "\n";
    $message .= "Session : " . $session->session_title . "\n";
    $message .= "Date : " . date('d/m/Y H:i', strtotime($session->date_debut)) . "\n\n";
    $message .= "Nous reviendrons vers vous rapidement pour confirmer votre inscription.\n\n";
    $message .= "Cordialement,\n";
    $message .= get_bloginfo('name');

    wp_mail($email, $subject, $message);
}

// Fonction d'envoi de notification admin
function cf_send_admin_notification($session_id, $prenom, $nom, $email) {
    $settings = get_option('cf_settings', array());
    $admin_email = $settings['email_admin'] ?? get_option('admin_email');

    $subject = 'Nouvelle inscription - Calendrier Formation';

    $message = "Nouvelle inscription reçue :\n\n";
    $message .= "Nom : $prenom $nom\n";
    $message .= "Email : $email\n";
    $message .= "Session ID : $session_id\n\n";
    $message .= "Voir toutes les réservations : " . admin_url('admin.php?page=cf-bookings');

    wp_mail($admin_email, $subject, $message);
}

/**
 * MÉTHODE 3 : JavaScript pour pré-remplir Contact Form 7
 */
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les paramètres de l'URL
    const urlParams = new URLSearchParams(window.location.search);

    // Contact Form 7 - pré-remplir les champs
    const formationField = document.querySelector('input[name="formation"]');
    if (formationField) {
        formationField.value = urlParams.get('formation') || '';
        formationField.readOnly = true;
    }

    const sessionField = document.querySelector('input[name="session"]');
    if (sessionField) {
        sessionField.value = urlParams.get('session') || '';
        sessionField.readOnly = true;
    }

    const dateField = document.querySelector('input[name="date_formation"]');
    if (dateField) {
        const dateDebut = urlParams.get('date_debut');
        if (dateDebut) {
            const date = new Date(dateDebut);
            dateField.value = date.toLocaleDateString('fr-FR');
            dateField.readOnly = true;
        }
    }

    // Ajouter les champs cachés
    const form = document.querySelector('.wpcf7-form');
    if (form) {
        const sessionId = urlParams.get('session_id');
        const bookingKey = urlParams.get('booking_key');

        if (sessionId) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'session_id';
            input.value = sessionId;
            form.appendChild(input);
        }

        if (bookingKey) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'booking_key';
            input.value = bookingKey;
            form.appendChild(input);
        }
    }
});
</script>

<?php
/**
 * MÉTHODE 4 : Afficher un message de confirmation
 */
?>
<div class="booking-messages">
    <?php
    if (isset($_GET['booking_status'])) {
        switch ($_GET['booking_status']) {
            case 'success':
                echo '<div class="alert alert-success">Votre inscription a été enregistrée avec succès ! Vous allez recevoir un email de confirmation.</div>';
                break;
            case 'full':
                echo '<div class="alert alert-warning">Désolé, cette session est complète.</div>';
                break;
            case 'error':
                echo '<div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer.</div>';
                break;
        }
    }
    ?>
</div>

<style>
/* Styles pour le formulaire */
.formulaire-inscription {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 15px;
}

.form-control-readonly {
    background: #f5f5f5;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
    width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.btn-primary {
    background: #667eea;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
}

.btn-primary:hover {
    background: #5568d3;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
