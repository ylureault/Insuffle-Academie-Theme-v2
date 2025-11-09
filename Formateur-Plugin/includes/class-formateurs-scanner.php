<?php
/**
 * Scanner des pages formateurs
 */

if (!defined('ABSPATH')) {
    exit;
}

class FFM_Formateurs_Scanner {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Constructor vide
    }

    /**
     * Récupère toutes les pages formateurs (pages enfants de "Formateurs")
     */
    public static function get_formateurs() {
        // Trouver la page parent "Formateurs"
        $formateurs_page = get_page_by_path('formateurs');

        if (!$formateurs_page) {
            // Essayer de trouver par titre
            $formateurs_page = get_page_by_title('Formateurs');
        }

        if (!$formateurs_page) {
            return array();
        }

        // Récupérer les pages enfants
        $args = array(
            'post_type' => 'page',
            'post_parent' => $formateurs_page->ID,
            'orderby' => 'menu_order title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'post_status' => 'publish,draft',
        );

        $formateurs = get_posts($args);

        // Enrichir avec les infos de la fiche
        foreach ($formateurs as &$formateur) {
            $data = FFM_Formateur_Manager::get_formateur_data($formateur->ID);
            $formateur->has_fiche = !empty($data['nom']) || !empty($data['photo_id']);
            $formateur->stats_count = isset($data['stats']) ? count($data['stats']) : 0;
        }

        return $formateurs;
    }

    /**
     * Compte le nombre de formateurs
     */
    public static function count_formateurs() {
        $formateurs = self::get_formateurs();
        return count($formateurs);
    }

    /**
     * Compte le nombre de formateurs avec fiche
     */
    public static function count_with_fiche() {
        $formateurs = self::get_formateurs();
        $count = 0;

        foreach ($formateurs as $formateur) {
            if ($formateur->has_fiche) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Vérifie si une page est un formateur
     */
    public static function is_formateur($post_id) {
        $formateurs = self::get_formateurs();

        foreach ($formateurs as $formateur) {
            if ($formateur->ID == $post_id) {
                return true;
            }
        }

        return false;
    }
}
