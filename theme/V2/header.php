<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
    
    <!-- Script inline pour le menu - garantit que ça fonctionne -->
    <style>
        /* Styles inline pour garantir le fonctionnement */
        .nav-menu .sub-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 280px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border-radius: 12px;
            padding: 15px 0;
            margin-top: 10px;
            list-style: none !important;
            z-index: 9999;
        }
        
        .nav-menu .menu-item-has-children:hover > .sub-menu {
            display: block;
        }
        
        .nav-menu .sub-menu li {
            margin: 0;
            padding: 0;
            list-style: none !important;
        }
        
        .nav-menu .sub-menu li::before,
        .nav-menu .sub-menu li::marker {
            display: none !important;
            content: none !important;
        }
        
        .nav-menu .sub-menu a {
            color: #8E2183 !important;
            padding: 12px 25px !important;
            display: block;
            border-left: 3px solid transparent;
        }
        
        .nav-menu .sub-menu a:hover {
            background: #f5f5f5;
            border-left-color: #FFD466;
            padding-left: 30px !important;
        }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Navigation -->
<nav id="site-header">
    <div class="container nav-container">
        <?php
        // Logo
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/img/Logo-Insuffle-Academie.png" width="200" 
                     alt="<?php bloginfo('name'); ?>" 
                     class="nav-logo">
            </a>
            <?php
        }
        ?>
        
        <!-- Menu Navigation WordPress -->
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav-menu',
            'walker'         => new Insuffle_Menu_Walker(),
            'fallback_cb'    => 'insuffle_fallback_menu',
        ));
        ?>
        
        <!-- Bouton hamburger pour mobile -->
        <button class="mobile-menu-toggle" aria-label="Menu mobile" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- Script JavaScript inline pour garantir le fonctionnement -->
<script>
// Toggle menu mobile
function toggleMobileMenu() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const menu = document.querySelector('.nav-menu');
    
    if (toggle && menu) {
        toggle.classList.toggle('active');
        menu.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }
}

// Gestion du sous-menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item-has-children > a');

    menuItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('submenu-open');

                // Fermer les autres sous-menus
                document.querySelectorAll('.menu-item-has-children').forEach(function(otherItem) {
                    if (otherItem !== parent) {
                        otherItem.classList.remove('submenu-open');
                    }
                });
            }
        });
    });

    // S'assurer que le bouton devis est présent
    const menu = document.querySelector('.nav-menu');
    if (menu) {
        // Vérifier si un bouton CTA existe déjà
        const hasCtaButton = menu.querySelector('.nav-cta');

        if (!hasCtaButton) {
            // Ajouter le bouton devis s'il n'existe pas
            const li = document.createElement('li');
            li.className = 'menu-item menu-item-cta';
            const a = document.createElement('a');
            a.href = '<?php echo esc_url(home_url('/#contact')); ?>';
            a.className = 'nav-cta';
            a.textContent = 'Demande de devis';
            li.appendChild(a);
            menu.appendChild(li);
        }
    }

    // Fermer le menu en cliquant en dehors
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-container')) {
            const toggle = document.querySelector('.mobile-menu-toggle');
            const menu = document.querySelector('.nav-menu');

            if (toggle) toggle.classList.remove('active');
            if (menu) menu.classList.remove('active');
            document.body.classList.remove('menu-open');
        }
    });
});
</script>

<main id="main-content">