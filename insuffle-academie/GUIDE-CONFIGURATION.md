# Guide de Configuration - Thème Insuffle Académie

## 🎯 Vue d'ensemble

Votre thème WordPress est maintenant **100% paramétrable** depuis l'administration WordPress. Plus besoin de toucher au code pour personnaliser le menu, le footer ou le blog!

---

## 📌 Configuration du Menu Principal

### Étape 1 : Créer un menu

1. Allez dans **Apparence > Menus**
2. Cliquez sur **Créer un nouveau menu**
3. Donnez-lui un nom (ex: "Menu Principal")
4. Cochez **Menu Principal** dans "Emplacement du thème"
5. Cliquez sur **Créer le menu**

### Étape 2 : Ajouter des éléments au menu

Ajoutez vos pages, liens personnalisés, catégories, etc. depuis la colonne de gauche.

### Étape 3 : Créer le bouton CTA "Demande de devis"

**C'est l'élément important à ne pas oublier!**

1. Ajoutez un **Lien personnalisé** au menu
2. URL : `/#contact` (ou l'URL de votre page contact)
3. Texte du lien : `Demande de devis`
4. Cliquez sur **Ajouter au menu**
5. **IMPORTANT** : Dans les paramètres de l'élément de menu :
   - Cliquez sur la petite flèche pour ouvrir les options
   - Si vous ne voyez pas "Classes CSS", cliquez sur "Options de l'écran" en haut à droite et cochez "Classes CSS"
   - Dans le champ **Classes CSS**, ajoutez : `cta`
   - Sauvegardez le menu

✅ Le bouton aura automatiquement le style jaune avec fond arrondi!

### Exemple de structure de menu

```
- Accueil
- Notre approche
- Formations ▾
  - Formation 1
  - Formation 2
  - Formation 3
- Blog
- Témoignages
- Contact
- Demande de devis [CLASSE: cta]
```

### Créer un sous-menu

Pour créer un menu déroulant (comme "Formations") :
1. Glissez-déposez l'élément légèrement vers la droite sous son parent
2. Il deviendra automatiquement un sous-élément

---

## 🦶 Configuration du Footer

Le footer est divisé en **4 colonnes personnalisables**.

### Accéder aux widgets

1. Allez dans **Apparence > Widgets**
2. Vous verrez 4 zones de widgets :
   - **Footer - Colonne 1** (À propos)
   - **Footer - Colonne 2** (Navigation)
   - **Footer - Colonne 3** (Formations)
   - **Footer - Colonne 4** (Contact)

### Widgets recommandés par colonne

#### Colonne 1 - À propos
- Widget **Texte** avec :
  - Titre : "Insuffle Académie"
  - Contenu : Description de votre organisme
  - Image du logo (optionnel)

#### Colonne 2 - Navigation
- Widget **Menu de navigation personnalisé**
- Sélectionnez votre menu footer (créez-le dans Apparence > Menus)

#### Colonne 3 - Formations
- Widget **Pages récentes** ou **Liste de pages**
- Filtrez pour afficher uniquement les pages de formations

#### Colonne 4 - Contact
- Widget **Texte** avec :
  - Titre : "Contact"
  - Contenu HTML :
```html
<p>📍 Deauville, Normandie<br>France</p>
<p>📞 <a href="tel:+33980808962">09 80 80 89 62</a></p>
<p>✉️ <a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a></p>
<p><strong>Organisme de formation certifié</strong><br>
<small>N° de déclaration d'activité : XXXXXXXX</small></p>
```

### Menu Footer

Pour le menu de navigation du footer :

1. Allez dans **Apparence > Menus**
2. Créez un nouveau menu "Menu Footer"
3. Cochez **Menu Footer** dans "Emplacement du thème"
4. Ajoutez vos liens (généralement plus simple que le menu principal)

Exemple de structure :
```
- Accueil
- Notre approche
- Nos formations
- Blog
- Contact
```

### Comportement par défaut

Si vous ne configurez **AUCUN widget**, le footer affichera automatiquement :
- Colonne 1 : Description Insuffle Académie + Logo
- Colonne 2 : Menu de navigation (ou liens par défaut)
- Colonne 3 : Liste des formations (automatique)
- Colonne 4 : Informations de contact par défaut

🎯 **Rien ne casse si vous ne configurez rien!**

---

## 📝 Blog - Affichage des Articles

### Création d'articles

1. Allez dans **Articles > Ajouter**
2. Créez votre article comme d'habitude
3. **Image mise en avant** : Sera affichée sur la carte du blog
4. **Catégorie** : Un badge sera affiché sur l'image
5. **Extrait** : Utilisé pour le résumé sur la carte (25 mots max)

### Design automatique du blog

Votre thème affiche automatiquement les articles avec :
- ✅ **Grid responsive** (3 colonnes desktop, 2 tablettes, 1 mobile)
- ✅ **Cards magnifiques** avec image, titre, extrait, métadonnées
- ✅ **Badge catégorie** sur l'image
- ✅ **Effets hover** élégants (zoom image, élévation card)
- ✅ **Pagination** stylisée
- ✅ **Métadonnées** : date, auteur, nombre de commentaires

### Pages blog disponibles

Le template `archive.php` fonctionne pour :
- `/blog/` - Tous les articles
- `/category/nom-categorie/` - Articles d'une catégorie
- `/tag/nom-tag/` - Articles d'un tag
- `/author/nom-auteur/` - Articles d'un auteur
- `/2024/01/` - Archives par date

### Hero section personnalisée

Chaque page d'archive affiche un hero avec :
- Titre automatique (ex: "Catégorie : Formation")
- Description de la catégorie/tag si disponible
- Dégradé violet avec effet visuel

---

## 🎨 Personnalisation CSS Avancée

### Couleurs du thème

Les couleurs sont gérées par des variables CSS dans `style.css` :

```css
:root {
    --primary: #8E2183;    /* Violet */
    --secondary: #FFD466;  /* Jaune */
    --accent: #FFC0CB;     /* Rose */
    --light: #FFFFFF;      /* Blanc */
    --dark: #333333;       /* Noir */
    --grey: #F5F5F5;       /* Gris clair */
    --text: #555555;       /* Texte */
}
```

Pour changer une couleur, modifiez la valeur hexadécimale.

### Classes CSS utiles

#### Pour le menu
- `.nav-cta` - Style bouton CTA (automatique si classe 'cta')
- `.menu-item-has-children` - Élément avec sous-menu
- `.sub-menu` - Le sous-menu dropdown

#### Pour le footer
- `.footer-column` - Une colonne du footer
- `.footer-links` - Liste de liens footer
- `.footer-widget` - Container de widget

#### Pour le blog
- `.blog-card` - Carte d'article
- `.blog-card-category` - Badge catégorie
- `.blog-card-image` - Image de la carte
- `.blog-pagination` - Pagination

---

## 🔧 Fonctionnalités Avancées

### Ajouter des icônes au menu

Dans le texte d'un élément de menu, vous pouvez ajouter des emojis :
```
🏠 Accueil
📚 Formations
✉️ Contact
```

### Personnaliser le bouton CTA

Si vous voulez un autre style pour le CTA :
1. Créez une classe CSS personnalisée dans **Apparence > Personnaliser > CSS additionnel**
2. Appliquez cette classe à votre élément de menu

Exemple :
```css
.nav-menu .mon-cta-custom {
    background: red;
    color: white;
    /* vos styles */
}
```

### Widgets personnalisés

Vous pouvez utiliser n'importe quel widget WordPress dans le footer :
- Texte
- HTML personnalisé
- Recherche
- Catégories
- Archives
- Nuage d'étiquettes
- Calendrier
- RSS
- Etc.

---

## 📱 Responsive

Tout est automatiquement responsive :
- Menu mobile avec hamburger
- Footer empilé sur mobile (4 colonnes → 2 → 1)
- Blog grid adaptatif (3 → 2 → 1)

**Aucune configuration nécessaire!**

---

## ✅ Checklist de Configuration

### Configuration Minimale
- [ ] Créer un menu principal
- [ ] Ajouter l'élément "Demande de devis" avec classe `cta`
- [ ] Assigner le menu à "Menu Principal"

### Configuration Recommandée
- [ ] Créer un menu footer
- [ ] Configurer les 4 widgets footer
- [ ] Ajouter quelques articles de blog
- [ ] Définir les catégories
- [ ] Ajouter des images mises en avant aux articles

### Configuration Avancée
- [ ] Personnaliser les couleurs CSS
- [ ] Créer des widgets personnalisés
- [ ] Ajouter des icônes au menu
- [ ] Configurer la sidebar des pages

---

## 🆘 Dépannage

### Le menu n'apparaît pas
- Vérifiez que le menu est bien assigné à "Menu Principal"
- Videz le cache si vous utilisez un plugin de cache

### Le bouton CTA n'a pas le bon style
- Vérifiez que la classe CSS `cta` est bien ajoutée à l'élément
- Activez l'option "Classes CSS" dans "Options de l'écran"

### Le footer affiche le contenu par défaut
- C'est normal si aucun widget n'est configuré
- Ajoutez des widgets dans Apparence > Widgets pour personnaliser

### Les articles de blog ne s'affichent pas bien
- Vérifiez que les articles ont une image mise en avant
- Ajoutez un extrait personnalisé pour un meilleur rendu

---

## 📚 Ressources

### Documentation WordPress
- [Créer un menu](https://wordpress.com/fr/support/menus/)
- [Utiliser les widgets](https://wordpress.com/fr/support/widgets/)
- [Gérer les articles](https://wordpress.com/fr/support/posts/)

### Support
Pour toute question : contact@insuffle-academie.com

---

**Version** : 3.3
**Dernière mise à jour** : 2025
**Thème** : Insuffle Académie
