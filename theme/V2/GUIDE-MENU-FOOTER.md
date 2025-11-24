# 🎯 Guide Rapide : Menu et Footer

## 📍 Comment configurer le menu WordPress

### Étape 1 : Créer votre menu
1. Dans WordPress, allez dans **Apparence > Menus**
2. Cliquez sur **Créer un nouveau menu**
3. Donnez-lui un nom (ex: "Menu Principal")
4. Cochez **Menu Principal** dans "Réglages du menu"
5. Cliquez sur **Créer le menu**

### Étape 2 : Ajouter des liens au menu
Dans la colonne de gauche, vous pouvez ajouter :
- **Pages** : vos pages WordPress
- **Liens personnalisés** : n'importe quelle URL
- **Articles** : liens vers des articles de blog
- **Catégories** : catégories de blog

Glissez-déposez les éléments vers la droite pour les ajouter au menu.

### Étape 3 : Créer le bouton CTA "Demande de devis"
1. Dans le menu, ajoutez un **Lien personnalisé**
2. URL : `#contact` ou votre page de contact
3. Texte du lien : `Demande de devis`
4. Cliquez sur **Classes CSS (avancé)** (en haut à droite, dans "Options de l'écran")
5. Dans le champ "Classes CSS", ajoutez : `cta`
6. Sauvegardez le menu

✅ Le bouton aura automatiquement le style jaune avec les bords arrondis !

---

## 🦶 Comment configurer le Footer

Le footer a **4 colonnes personnalisables** avec des widgets.

### Où configurer le footer
1. Allez dans **Apparence > Widgets**
2. Vous verrez 4 zones :
   - **Footer - Colonne 1** (À propos)
   - **Footer - Colonne 2** (Navigation)
   - **Footer - Colonne 3** (Formations)
   - **Footer - Colonne 4** (Contact)

### Que mettre dans chaque colonne ?

#### Colonne 1 - À propos
Ajoutez un widget **Texte** avec :
- Logo de l'entreprise
- Description courte
- Image

#### Colonne 2 - Navigation
Ajoutez un widget **Menu de navigation** :
- Créez un menu "Menu Footer" dans Apparence > Menus
- Cochez "Menu Footer" dans les réglages
- Sélectionnez ce menu dans le widget

OU utilisez le widget **Liens** avec vos liens importants

#### Colonne 3 - Formations
Ajoutez un widget **Texte** ou **Liens** avec :
- Liste de vos formations principales
- Lien vers la page formations

#### Colonne 4 - Contact
Ajoutez un widget **Texte** avec :
- Adresse
- Téléphone
- Email
- Certification Qualiopi

### 💡 Widgets utiles
- **Texte** : pour du contenu HTML personnalisé
- **Menu de navigation** : pour afficher un menu
- **Liens** : pour une liste de liens
- **Image** : pour ajouter des images/logos

---

## 🎨 Utiliser les Compositions WordPress

Les compositions sont des blocs pré-conçus réutilisables.

### Comment les utiliser
1. Éditez une page avec Gutenberg
2. Cliquez sur le bouton **+** (Ajouter un bloc)
3. Allez dans l'onglet **Motifs**
4. Cherchez la catégorie **Insuffle Académie**
5. Cliquez sur la composition que vous voulez insérer

### Compositions disponibles
- Hero avec Gradient
- Fonctionnalités 3 Colonnes
- CTA Simple
- Témoignage
- Grille Services 2x2
- Section Statistiques
- Image + Texte
- Footer 4 Colonnes

---

## 📝 Templates de Page

Lors de la création d'une page, dans la colonne de droite sous **Template**, vous pouvez choisir parmi :

- **Pages > Pleine Largeur** : contenu sans sidebar
- **Pages > Landing** : page sans header/footer (campagnes)
- **Pages > Avec Sidebar** : avec sidebar à droite
- **Pages > Contact** : formulaire de contact stylé
- **Pages > Tarifs** : pour afficher vos prix
- **Pages > FAQ** : questions/réponses
- **Pages > Équipe** : présentation de l'équipe
- **Pages > Services** : grille de services
- **Pages > Témoignages** : avis clients
- **Blog > Liste Articles** : page d'archives du blog

---

## ❓ Problèmes fréquents

### Le menu ne s'affiche pas
- Vérifiez que vous avez créé un menu
- Vérifiez qu'il est assigné à "Menu Principal"
- Rafraîchissez la page

### Le footer affiche du contenu par défaut
- C'est normal si vous n'avez pas ajouté de widgets
- Ajoutez des widgets dans Apparence > Widgets pour personnaliser

### Le bouton CTA n'a pas le bon style
- Vérifiez que vous avez ajouté la classe CSS `cta` au lien dans le menu
- Activez "Classes CSS" dans Options de l'écran des menus
