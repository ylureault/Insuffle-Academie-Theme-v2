# Formation Gallery Plugin

Plugin WordPress pour gérer des galeries photos avancées pour les formations.

## Fonctionnalités

✨ **Gestion avancée de galeries**
- Interface intuitive dans l'administration WordPress
- Ajout multiple d'images via le media library
- Réorganisation par glisser-déposer (drag & drop)
- Légendes personnalisables pour chaque image

🎨 **Affichage frontend moderne**
- Lightbox élégante (GLightbox)
- Grille responsive (2, 3, 4, ou 5 colonnes)
- Animations fluides au survol
- Support des légendes d'images
- Style masonry disponible

📱 **Responsive**
- Adaptation automatique aux mobiles, tablettes et desktop
- Lazy loading des images
- Performance optimisée

## Installation

1. Télécharger le dossier `Formation-Gallery-Plugin`
2. Le placer dans `/wp-content/plugins/`
3. Activer le plugin dans l'administration WordPress

## Utilisation

### Dans l'administration

1. Aller dans **Formations** > Modifier une formation
2. Trouver la meta box **"Galerie photos de la formation"**
3. Cliquer sur **"Ajouter des images"**
4. Sélectionner les images depuis la bibliothèque média
5. Réorganiser les images par glisser-déposer
6. Ajouter des légendes (optionnel)
7. Enregistrer la formation

### Affichage sur le site

#### Shortcode

```php
// Dans le contenu d'une page ou formation
[formation_gallery]

// Avec options
[formation_gallery id="123" columns="4" style="grid" show_captions="yes"]
```

#### Dans les templates PHP

```php
// Afficher la galerie de la formation courante
<?php
if (function_exists('fg_the_gallery')) {
    fg_the_gallery();
}
?>

// Avec options personnalisées
<?php
fg_the_gallery(get_the_ID(), array(
    'columns' => 4,
    'size' => 'large',
    'style' => 'grid',
    'show_captions' => 'yes'
));
?>

// Vérifier si une formation a une galerie
<?php
if (fg_has_gallery()) {
    echo '<h2>Galerie photos</h2>';
    fg_the_gallery();
}
?>

// Obtenir le nombre d'images
<?php
$count = fg_get_gallery_count();
echo "Cette formation contient {$count} photos";
?>
```

### Paramètres disponibles

| Paramètre | Valeurs | Défaut | Description |
|-----------|---------|---------|-------------|
| `id` | ID formation | ID actuelle | ID de la formation |
| `columns` | 2, 3, 4, 5 | 3 | Nombre de colonnes |
| `size` | thumbnail, medium, large, full | medium | Taille des images |
| `style` | grid, masonry | grid | Style d'affichage |
| `show_captions` | yes, no | yes | Afficher les légendes |

## Fonctions helper

```php
// Vérifier si une formation a une galerie
fg_has_gallery($formation_id);

// Obtenir le nombre d'images dans la galerie
fg_get_gallery_count($formation_id);

// Afficher la galerie
fg_the_gallery($formation_id, $args);
```

## Personnalisation CSS

Le plugin charge automatiquement ses styles, mais vous pouvez les personnaliser dans votre thème :

```css
/* Personnaliser l'espacement */
.fg-gallery {
    gap: 30px;
}

/* Personnaliser les bordures */
.fg-gallery-item {
    border-radius: 15px;
}

/* Personnaliser l'overlay */
.fg-gallery-overlay {
    background: rgba(0, 115, 170, 0.8);
}
```

## Compatibilité

- WordPress 5.0+
- PHP 7.4+
- Compatible avec tous les thèmes modernes
- Testé avec Gutenberg et l'éditeur classique

## Structure du plugin

```
Formation-Gallery-Plugin/
├── formation-gallery.php          # Fichier principal
├── includes/
│   ├── class-gallery-metabox.php  # Gestion de la meta box admin
│   └── class-gallery-shortcode.php # Gestion du shortcode
├── assets/
│   ├── css/
│   │   ├── frontend.css           # Styles frontend
│   │   └── admin.css              # Styles admin
│   └── js/
│       ├── frontend.js            # JavaScript frontend
│       └── admin.js               # JavaScript admin
└── README.md
```

## Technologies utilisées

- **GLightbox** - Lightbox moderne et légère
- **jQuery UI Sortable** - Drag & drop
- **WordPress Media Library** - Gestion des médias
- **CSS Grid** - Mise en page responsive

## Support

Pour toute question ou problème, créer une issue sur le repository GitHub.

## Licence

GPL v2 or later

## Auteur

Insuffle Académie
