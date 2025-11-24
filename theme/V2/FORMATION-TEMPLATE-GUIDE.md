# Guide d'utilisation du Template Formation Gamifiée

## 📋 Vue d'ensemble

Le template **Formation Gamifiée** est un modèle de page WordPress conçu spécialement pour vos pages de formations. Il offre un design moderne, immersif et engageant avec des cartes interactives, des animations et une mise en page optimisée.

## 🎨 Classes CSS disponibles

### 1. Cards (Cartes)

#### `.card-style` - Carte standard avec hover
```html
<!-- wp:column {"className":"card-style"} -->
<div class="wp-block-column card-style">
    <!-- wp:heading {"level":4} -->
    <h4 class="wp-block-heading">🎯 Titre de la carte</h4>
    <!-- /wp:heading -->

    <!-- wp:list -->
    <ul>
        <li>Point 1</li>
        <li>Point 2</li>
    </ul>
    <!-- /wp:list -->
</div>
<!-- /wp:column -->
```

**Caractéristiques :**
- Fond gris clair
- Effet hover avec élévation
- Bordure violette au survol
- Parfait pour les objectifs pédagogiques

#### `.card-light` - Carte centrée avec fond blanc
```html
<!-- wp:column {"className":"card-light"} -->
<div class="wp-block-column card-light">
    <!-- wp:heading {"level":3} -->
    <h3>👨‍💼</h3>
    <!-- /wp:heading -->

    <!-- wp:heading {"level":4} -->
    <h4>Titre</h4>
    <!-- /wp:heading -->

    <!-- wp:paragraph -->
    <p>Description...</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
```

**Caractéristiques :**
- Fond blanc
- Texte centré
- Ombre douce
- Parfait pour les profils cibles

#### `.card-highlight` - Carte mise en avant
```html
<!-- wp:column {"className":"card-highlight"} -->
<div class="wp-block-column card-highlight">
    <!-- wp:heading {"level":4} -->
    <h4>🌱 Niveau 1 : APPRENTI</h4>
    <!-- /wp:heading -->

    <!-- wp:paragraph -->
    <p><strong>Découverte des fondamentaux</strong></p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
```

**Caractéristiques :**
- Bordure jaune (secondary)
- Barre de couleur en haut
- Effet de mise en avant
- Parfait pour les niveaux/étapes importantes

### 2. Sections

#### `.section-grey` - Section avec fond gris
```html
<!-- wp:group {"className":"section-grey","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-grey">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2>Titre de la section</h2>
    <!-- /wp:heading -->

    <!-- Contenu... -->
</div>
<!-- /wp:group -->
```

**Caractéristiques :**
- Fond gris avec dégradé subtil
- Padding généreux
- Bordures arrondies
- Parfait pour séparer les sections

## 🚀 Comment utiliser le template

### Étape 1 : Créer une nouvelle page
1. Allez dans **Pages > Ajouter**
2. Donnez un titre à votre page (ex: "FACILIT'ACADEMY")

### Étape 2 : Sélectionner le template
1. Dans le panneau de droite, cherchez **Attributs de la page**
2. Dans le menu déroulant **Modèle**, sélectionnez **Formation Gamifiée**

### Étape 3 : Construire votre page avec Gutenberg

#### Exemple : Hero Section (En-tête)
```html
<!-- wp:group {"style":{"spacing":{"padding":{"top":"100px","bottom":"150px","left":"40px","right":"40px"}},"color":{"background":"#8E2183"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="background-color:#8E2183;padding-top:100px;padding-right:40px;padding-bottom:150px;padding-left:40px">

    <!-- wp:heading {"textAlign":"center","level":1,"textColor":"white"} -->
    <h1 class="has-text-align-center has-white-color has-text-color">
        🎮 FACILIT'ACADEMY
    </h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","textColor":"white"} -->
    <p class="has-text-align-center has-white-color has-text-color">
        La première formation facilitateur 100% gamifiée
    </p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
        <!-- Boutons CTA -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->
```

#### Exemple : Objectifs avec Cards
```html
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"30px","left":"30px"}}}} -->
<div class="wp-block-columns">

    <!-- wp:column {"className":"card-style"} -->
    <div class="wp-block-column card-style">
        <!-- wp:heading {"level":4} -->
        <h4>🎯 Badge POSTURE</h4>
        <!-- /wp:heading -->

        <!-- wp:list -->
        <ul>
            <li>Comprendre les fondements de la facilitation</li>
            <li>Adopter une posture juste et consciente</li>
        </ul>
        <!-- /wp:list -->
    </div>
    <!-- /wp:column -->

    <!-- Répéter pour chaque badge -->

</div>
<!-- /wp:columns -->
```

#### Exemple : Programme avec Cards Highlight
```html
<!-- wp:columns -->
<div class="wp-block-columns">

    <!-- wp:column {"className":"card-highlight"} -->
    <div class="wp-block-column card-highlight">
        <!-- wp:heading {"level":4} -->
        <h4>🌱 Niveau 1 : APPRENTI</h4>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p><strong>Découverte des fondamentaux</strong></p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph {"fontSize":"small"} -->
        <p class="has-small-font-size">
            • Posture du facilitateur<br>
            • Bases de l'intelligence collective
        </p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

</div>
<!-- /wp:columns -->
```

## 🎨 Palette de couleurs

Le thème utilise les variables CSS suivantes :

- **Primary (Violet)** : `#8E2183` - `var(--primary)`
- **Secondary (Jaune)** : `#FFD466` - `var(--secondary)`
- **Accent (Rose)** : `#FFC0CB` - `var(--accent)`
- **Light (Blanc)** : `#FFFFFF` - `var(--light)`
- **Dark (Noir)** : `#333333` - `var(--dark)`
- **Grey (Gris)** : `#F5F5F5` - `var(--grey)`
- **Text (Texte)** : `#555555` - `var(--text)`

## 📱 Responsive Design

Toutes les classes sont entièrement responsive :

- **Desktop** : Design complet avec animations
- **Tablette** : Colonnes adaptées
- **Mobile** : Cards empilées verticalement, padding réduit

## ✨ Effets et Animations

### Hover Effects
- Cards s'élèvent légèrement au survol
- Ombres qui s'intensifient
- Transitions fluides (0.3s)

### Animations d'apparition
- Effet `fadeInUp` sur les cards
- Apparition progressive et élégante

## 💡 Conseils d'utilisation

### ✅ Bonnes pratiques

1. **Utilisez les emojis** pour rendre le contenu visuel et engageant
2. **Alternez les types de cards** pour éviter la monotonie
3. **Utilisez `.section-grey`** pour séparer les grandes sections
4. **Gardez un rythme visuel** avec des espacers cohérents

### ❌ À éviter

1. Ne pas mélanger trop de styles de cards dans une même section
2. Ne pas oublier les espacers entre les sections
3. Ne pas surcharger avec trop de couleurs personnalisées

## 🔧 Personnalisation avancée

### Ajouter une couleur de fond personnalisée
```html
<!-- wp:group {"style":{"color":{"background":"#8E2183"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="background-color:#8E2183">
    <!-- Contenu avec texte blanc -->
</div>
<!-- /wp:group -->
```

### Créer des boutons CTA personnalisés
```html
<!-- wp:button {"style":{"border":{"radius":"30px"},"spacing":{"padding":{"left":"40px","right":"40px","top":"18px","bottom":"18px"}},"color":{"background":"#FFD466","text":"#8E2183"}}} -->
<div class="wp-block-button">
    <a class="wp-block-button__link has-text-color has-background wp-element-button"
       href="mailto:contact@insuffle-academie.com"
       style="border-radius:30px;padding-top:18px;padding-right:40px;padding-bottom:18px;padding-left:40px;background-color:#FFD466;color:#8E2183">
        🚀 Je rejoins l'aventure
    </a>
</div>
<!-- /wp:button -->
```

## 📚 Exemples complets

Consultez les fichiers HTML d'exemple (maintenant supprimés du repo mais disponibles sur demande) pour voir des implémentations complètes :
- FACILIT'ACADEMY
- Manager Facilitateur
- Électrochoc & Réanimation

## 🆘 Support

Pour toute question ou personnalisation supplémentaire, contactez l'équipe de développement.

---

**Version** : 1.0
**Dernière mise à jour** : <?php echo date('d/m/Y'); ?>
**Compatibilité** : WordPress 6.0+, Gutenberg
