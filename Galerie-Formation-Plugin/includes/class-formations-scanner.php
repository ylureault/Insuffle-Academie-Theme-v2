<?php
/**
 * Scanner des pages formations pour la galerie
 */

if (!defined('ABSPATH')) {
    exit;
}

class GFM_Formations_Scanner {

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
     * Récupère toutes les formations (pages enfants de "Formations")
     */
    public static function get_formations() {
        // Trouver la page parent "Formations"
        $formations_page = get_page_by_path('formations');

        if (!$formations_page) {
            // Essayer de trouver par titre
            $formations_page = get_page_by_title('Formations');
        }

        if (!$formations_page) {
            return array();
        }

        // Récupérer les pages enfants
        $args = array(
            'post_type' => 'page',
            'post_parent' => $formations_page->ID,
            'orderby' => 'menu_order title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'post_status' => 'publish,draft',
        );

        $formations = get_posts($args);

        // Enrichir avec les infos de la galerie
        foreach ($formations as &$formation) {
            $images = GFM_Gallery_Manager::get_images($formation->ID);
            $formation->images_count = count($images);
            $formation->has_galerie = !empty($images);
        }

        return $formations;
    }

    /**
     * Compte le nombre de formations
     */
    public static function count_formations() {
        $formations = self::get_formations();
        return count($formations);
    }

    /**
     * Compte le nombre de formations avec galerie
     */
    public static function count_with_galerie() {
        $formations = self::get_formations();
        $count = 0;

        foreach ($formations as $formation) {
            if ($formation->has_galerie) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Vérifie si une page est une formation
     */
    public static function is_formation($post_id) {
        $formations = self::get_formations();

        foreach ($formations as $formation) {
            if ($formation->ID == $post_id) {
                return true;
            }
        }

        return false;
    }
}
