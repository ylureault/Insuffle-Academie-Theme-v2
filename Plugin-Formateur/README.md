# Plugin Formateur

Plugin WordPress pour gérer et afficher les formateurs avec un design moderne basé sur les templates Insuffle Académie.

## Fonctionnalités

✨ **Gestion complète des formateurs**
- Custom Post Type dédié aux formateurs
- Interface intuitive dans l'administration WordPress
- Tous les champs sont paramétrables
- Photo de profil (image mise en avant)
- Biographie complète (éditeur de contenu)

🎨 **Design professionnel**
- Basé sur le design Insuffle Académie
- Couleurs de la charte graphique (#8E2183, #FFD466)
- Responsive (mobile, tablette, desktop)
- Animations fluides

📝 **Champs personnalisables**
- Nom du formateur
- Titre / Fonction
- Citation / Devise personnelle
- Biographie complète
- Spécialités
- Certifications
- Années d'expérience
- Email
- Téléphone
- LinkedIn
- Twitter/X
- Site web
- Ordre d'affichage

🎯 **Shortcodes puissants**
- `[formateur]` - Affiche Yoan Lureault par défaut
- `[formateur nom="..."]` - Affiche un formateur spécifique
- `[formateurs]` - Affiche tous les formateurs
- Paramètres d'affichage personnalisables

## Installation

1. Télécharger le dossier `Plugin-Formateur`
2. Le placer dans `/wp-content/plugins/`
3. Activer le plugin dans l'administration WordPress
4. **Yoan Lureault est créé automatiquement à l'activation !**

## Utilisation

### Dans l'administration

1. Aller dans **Formateurs** > **Ajouter un formateur**
2. Remplir les informations :
   - **Titre** : Nom du formateur
   - **Contenu** : Biographie complète (éditeur riche)
   - **Image mise en avant** : Photo du formateur
   - **Informations du formateur** : Titre, citation, spécialités, etc.
   - **Réseaux sociaux et contact** : Email, téléphone, LinkedIn, etc.
   - **Paramètres d'affichage** : Ordre, options d'affichage
3. **Publier**

### Affichage sur le site

#### Shortcode simple

```
[formateur]
```
Affiche **Yoan Lureault** par défaut.

#### Shortcode avec nom

```
[formateur nom="Yoan Lureault"]
[formateur nom="Jean Dupont"]
```

#### Shortcode avec ID

```
[formateur id="123"]
```

#### Afficher tous les formateurs

```
[formateurs]
```

#### Afficher un nombre limité

```
[formateurs nombre="3"]
```

#### Afficher des formateurs spécifiques

```
[formateurs ids="1,2,3"]
```

### Dans les templates PHP

```php
// Afficher Yoan Lureault (par défaut)
<?php afficher_formateur(); ?>

// Afficher un formateur spécifique
<?php afficher_formateur('Jean Dupont'); ?>

// Afficher tous les formateurs
<?php afficher_formateurs(); ?>

// Afficher 3 formateurs
<?php afficher_formateurs(3); ?>

// Utiliser le shortcode
<?php echo do_shortcode('[formateur]'); ?>
```

## Yoan Lureault - Formateur par défaut

À l'activation du plugin, **Yoan Lureault** est automatiquement créé avec les informations suivantes :

- **Nom** : Yoan Lureault
- **Titre** : Responsable pédagogique — Insuffle Académie
- **Citation** : "On ne forme pas à faire des ateliers. On forme à voir, écouter, tenir et transformer le collectif."
- **Biographie** : Formateur-facilitateur expérimenté, certifié par Insuffle Académie, Yoan accompagne les organisations dans leur transformation par l'intelligence collective depuis plusieurs années.
- **Contact** : yoan@insuffle-academie.com / 09 80 80 89 62

Vous pouvez modifier ces informations à tout moment dans **Formateurs** > **Yoan Lureault**.

## Personnalisation

### Champs disponibles

Dans l'admin WordPress, chaque formateur dispose de :

**Informations du formateur :**
- Titre / Fonction
- Citation / Devise
- Spécialités (liste)
- Certifications (liste)
- Années d'expérience

**Réseaux sociaux et contact :**
- Email
- Téléphone
- LinkedIn
- Twitter/X
- Site web

**Paramètres d'affichage :**
- Ordre d'affichage (1, 2, 3...)
- Afficher la citation (oui/non)
- Afficher les spécialités (oui/non)
- Afficher les informations de contact (oui/non)

### Personnalisation CSS

Vous pouvez personnaliser le design dans votre thème :

```css
/* Changer la couleur principale */
.formateur-section {
    --primary: #8E2183; /* Votre couleur */
}

/* Personnaliser la carte formateur */
.formateur-highlight-box {
    padding: 60px;
    border-radius: 20px;
}

/* Personnaliser la photo */
.formateur-photo-img {
    width: 250px;
    height: 250px;
    border: 8px solid var(--primary);
}
```

## Structure du plugin

```
Plugin-Formateur/
├── plugin-formateur.php                # Fichier principal
├── includes/
│   ├── class-formateur-cpt.php        # Custom Post Type
│   ├── class-formateur-metabox.php    # Meta boxes
│   └── class-formateur-shortcode.php  # Shortcodes
├── assets/
│   ├── css/
│   │   ├── frontend.css               # Styles frontend
│   │   └── admin.css                  # Styles admin
│   └── js/
│       └── frontend.js                # JavaScript frontend
└── README.md
```

## Exemples d'intégration

### Dans une page formation

```php
<!-- Single formation template -->
<div class="formation-content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>

    <!-- Afficher le formateur -->
    <?php echo do_shortcode('[formateur]'); ?>
</div>
```

### Dans une page équipe

```php
<!-- Page template équipe -->
<div class="page-equipe">
    <h1>Notre équipe de formateurs</h1>

    <!-- Afficher tous les formateurs -->
    <?php echo do_shortcode('[formateurs]'); ?>
</div>
```

### Widget sidebar

```php
<!-- Dans un widget -->
<div class="widget formateur-widget">
    <h3>Formateur de cette formation</h3>
    <?php afficher_formateur('Yoan Lureault'); ?>
</div>
```

## Classes CSS disponibles

- `.formateur-section` - Section complète
- `.formateur-container` - Conteneur principal
- `.formateur-highlight-box` - Carte du formateur
- `.formateur-photo` - Conteneur de la photo
- `.formateur-photo-img` - Image du formateur
- `.formateur-nom` - Nom du formateur
- `.formateur-titre` - Titre/fonction
- `.formateur-quote-block` - Citation
- `.formateur-biographie` - Biographie
- `.formateur-specialites` - Liste des spécialités
- `.formateur-certifications` - Liste des certifications
- `.formateur-contact` - Section contact
- `.formateur-contact-link` - Liens de contact
- `.formateurs-liste` - Grille de plusieurs formateurs

## Compatibilité

- WordPress 5.0+
- PHP 7.4+
- Compatible avec tous les thèmes modernes
- Testé avec Gutenberg et l'éditeur classique

## Design

Le design est basé sur les templates HTML d'Insuffle Académie avec :
- **Couleur principale** : #8E2183 (violet)
- **Couleur secondaire** : #FFD466 (jaune)
- **Police** : Montserrat (Google Fonts recommandée)
- **Style** : Moderne, épuré, professionnel

## Support

Pour toute question ou problème, créer une issue sur le repository GitHub.

## Licence

GPL v2 or later

## Auteur

Insuffle Académie
