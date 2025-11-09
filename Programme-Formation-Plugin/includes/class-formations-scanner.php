<?php
/**
 * Scanner des pages enfants de "Formations"
 */

if (!defined('ABSPATH')) {
    exit;
}

class PFM_Formations_Scanner {

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

        // Enrichir avec les infos du programme
        foreach ($formations as &$formation) {
            $modules = PFM_Modules_Manager::get_modules($formation->ID);
            $formation->modules_count = count($modules);
            $formation->has_programme = !empty($modules);
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
     * Compte le nombre de formations avec programme
     */
    public static function count_with_programme() {
        $formations = self::get_formations();
        $count = 0;

        foreach ($formations as $formation) {
            if ($formation->has_programme) {
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
