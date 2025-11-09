# Galerie Formation Plugin

Plugin WordPress pour créer et gérer des galeries d'images pour vos formations.

## 📋 Description

Ce plugin vous permet de créer facilement des galeries d'images professionnelles avec :
- ✅ Upload d'images illimité via média WordPress
- ✅ Tous les champs optionnels (titre, description, catégorie)
- ✅ Glisser-déposer pour réorganiser
- ✅ Système de catégories pour filtrer
- ✅ Design identique au HTML (formation-sketchnote.html)
- ✅ Classes CSS préfixées "gfm-"
- ✅ Effet overlay au survol
- ✅ Responsive complet

## 🚀 Installation

1. Téléchargez le dossier `Galerie-Formation-Plugin`
2. Placez-le dans `/wp-content/plugins/`
3. Activez le plugin depuis l'interface WordPress
4. Un nouveau menu "Galerie" apparaît dans votre admin

## 💻 Utilisation

### 1. Ajouter des images

Sur chaque page ou article, une metabox **"Galerie Formation - Images"** vous permet d'ajouter des images.

#### Étapes :
1. Cliquez sur "Ajouter une image"
2. Sélectionnez une image dans la médiathèque
3. Remplissez les champs optionnels :
   - **Titre** : Affiché au survol
   - **Description** : Affichée au survol
   - **Catégorie** : Pour filtrer (ex: sketchnote, facilitation)

### 2. Gérer les images

- ✅ **Réorganiser** : Glissez-déposez les images
- ✅ **Changer** : Cliquez sur "Changer" pour remplacer l'image
- ✅ **Supprimer** : Cliquez sur "Supprimer"

### 3. Afficher la galerie

Utilisez le shortcode dans votre contenu :

```
[galerie_formation]
```

## 📝 Shortcode et paramètres

### Shortcode de base

```
[galerie_formation]
```

### Paramètres disponibles

| Paramètre | Description | Défaut | Exemple |
|-----------|-------------|--------|---------|
| `post_id` | ID du post/page | Page actuelle | `post_id="123"` |
| `category` | Filtrer par catégorie | Toutes | `category="sketchnote"` |
| `columns` | Nombre de colonnes | 3 | `columns="4"` |
| `titre` | Titre de la section | Vide | `titre="Nos réalisations"` |
| `sous_titre` | Sous-titre de la section | Vide | `sous_titre="Portfolio"` |
| `description` | Description | Vide | `description="Découvrez..."` |

### Exemples

#### Galerie simple
```
[galerie_formation]
```

#### Avec titres et textes
```
[galerie_formation
    titre="Exemples de Sketchnotes réalisés"
    sous_titre="Portfolio"
    description="Découvrez des exemples concrets créés lors de nos formations"]
```

#### 4 colonnes
```
[galerie_formation columns="4"]
```

#### Filtrer par catégorie
```
[galerie_formation category="sketchnote"]
```

#### Plusieurs galeries filtrées
```
<!-- Galerie des sketchnotes -->
[galerie_formation
    category="sketchnote"
    titre="Sketchnotes"
    columns="3"]

<!-- Galerie de facilitation -->
[galerie_formation
    category="facilitation"
    titre="Facilitation graphique"
    columns="4"]
```

## 🎨 Design

Le plugin reproduit exactement le design de la section galerie du HTML avec :

### Caractéristiques
- Grille responsive automatique
- Images de hauteur fixe (300px)
- Effet zoom au survol (scale 1.05)
- Overlay violet au survol
- Titre et description affichés au survol
- Coins arrondis
- Ombres portées

### Couleurs
- **Violet principal** : `#8E2183`
- **Overlay** : Gradient violet avec opacité

### Classes CSS disponibles

- `.gfm-gallery-section` - Section complète
- `.gfm-gallery-container` - Container
- `.gfm-section-subtitle` - Sous-titre
- `.gfm-section-title` - Titre
- `.gfm-section-description` - Description
- `.gfm-image-grid` - Grille d'images
- `.gfm-gallery-item` - Item individuel
- `.gfm-gallery-image` - Image
- `.gfm-gallery-overlay` - Overlay au survol
- `.gfm-gallery-title` - Titre de l'image
- `.gfm-gallery-description` - Description de l'image

## 📱 Responsive

Le plugin est entièrement responsive avec :

### Desktop (> 768px)
- Grille multi-colonnes
- Overlay visible au survol uniquement

### Tablette (≤ 768px)
- 2 colonnes adaptatives
- Overlay visible au survol

### Mobile (≤ 480px)
- 1 colonne
- Overlay toujours visible (pas de survol tactile)
- Images de hauteur 200px

## 🎯 Cas d'usage

### Portfolio de formations
```
[galerie_formation
    titre="Nos réalisations"
    sous_titre="Portfolio"
    description="Découvrez les créations de nos participants"]
```

### Exemples par thème
```
<!-- Sketchnotes -->
[galerie_formation
    category="sketchnote"
    titre="Sketchnoting"]

<!-- Facilitation -->
[galerie_formation
    category="facilitation"
    titre="Facilitation graphique"]
```

### Galerie complète
```
[galerie_formation
    titre="Toutes nos réalisations"
    columns="4"]
```

## 🔧 Fonctionnalités

### Interface Admin
- ✅ Metabox sur pages et articles
- ✅ Upload via médiathèque WordPress
- ✅ Glisser-déposer pour réorganiser
- ✅ Champs optionnels (titre, description, catégorie)
- ✅ Aperçu thumbnail
- ✅ Boutons Changer/Supprimer

### Frontend
- ✅ Design identique au HTML
- ✅ Classes préfixées "gfm-"
- ✅ Grille responsive
- ✅ Effet hover avec zoom
- ✅ Overlay au survol
- ✅ Lazy loading natif
- ✅ Optimisé SEO (alt tags)

### Shortcode
- ✅ Simple et flexible
- ✅ Filtrage par catégorie
- ✅ Colonnes personnalisables
- ✅ Titres/textes optionnels
- ✅ Plusieurs galeries par page

## 🔐 Sécurité

- ✅ Nonces WordPress
- ✅ Vérifications des permissions
- ✅ Sanitization des champs
- ✅ Echappement des sorties
- ✅ Protection contre l'accès direct

## 📄 Structure des fichiers

```
Galerie-Formation-Plugin/
├── galerie-formation.php            # Fichier principal
├── includes/
│   ├── class-gallery-manager.php    # Gestion metabox et images
│   ├── class-shortcode.php          # Shortcode
│   └── class-admin-interface.php    # Menu et aide
├── assets/
│   ├── css/
│   │   ├── frontend.css             # Styles identiques au HTML
│   │   └── admin.css                # Styles admin
│   └── js/
│       ├── frontend.js              # Scripts frontend
│       └── admin.js                 # Upload et glisser-déposer
├── templates/
│   └── admin-metabox.php            # Template metabox
├── README.md                        # Ce fichier
└── VERIFICATION.md                  # Guide de tests
```

## 🆘 Support

### Page d'aide intégrée
Consultez **WordPress > Galerie** pour la documentation complète.

### Problèmes courants

**Les images ne s'affichent pas ?**
- Vérifiez que vous avez uploadé des images dans la metabox
- Vérifiez le shortcode `[galerie_formation]`
- Vérifiez que les images existent dans la médiathèque

**Les styles ne s'appliquent pas ?**
- Videz le cache du navigateur (Ctrl+F5)
- Vérifiez qu'il n'y a pas de conflit CSS dans votre thème

**L'upload ne fonctionne pas ?**
- Vérifiez les permissions d'upload WordPress
- Vérifiez la taille maximale des fichiers
- Consultez la console JavaScript pour les erreurs

## 💡 Conseils

- Utilisez des images de bonne qualité (min 800x600px)
- Nommez vos catégories de manière cohérente
- Remplissez les alt tags pour le SEO
- Optimisez vos images avant upload
- Utilisez le format WebP si possible

## 📊 Compatibilité

- **WordPress** : 5.0+
- **PHP** : 7.0+
- **Navigateurs** : Chrome, Firefox, Safari, Edge
- **Mobile** : iOS, Android

## 📝 Changelog

### Version 1.0.0
- ✨ Première version
- ✨ Upload d'images via médiathèque
- ✨ Glisser-déposer
- ✨ Système de catégories
- ✨ Shortcode [galerie_formation]
- ✨ Design identique au HTML
- ✨ Classes préfixées "gfm-"
- ✨ Responsive complet

## 👨‍💻 Auteur

**Yoan Lureault**
- GitHub: https://github.com/ylureault
- Site: https://www.insuffle-academie.com

## 📄 License

GPL v2 or later

---

**Merci d'utiliser Galerie Formation !** 🎉
