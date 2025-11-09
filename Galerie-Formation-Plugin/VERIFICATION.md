# ✅ Guide de Vérification - Galerie Formation Plugin

## 📋 Checklist d'installation

### Étape 1 : Activation
- [ ] Plugin activé dans WordPress
- [ ] Aucune erreur PHP affichée
- [ ] Menu "Galerie" visible dans l'admin

### Étape 2 : Interface Admin
- [ ] Metabox "Galerie Formation - Images" visible sur les pages
- [ ] Metabox "Galerie Formation - Images" visible sur les articles
- [ ] Bouton "Ajouter une image" ouvre la médiathèque
- [ ] L'image sélectionnée s'affiche en aperçu
- [ ] Les images peuvent être réorganisées par glisser-déposer
- [ ] Le bouton "Changer" permet de remplacer une image
- [ ] Le bouton "Supprimer" fonctionne avec confirmation

### Étape 3 : Sauvegarde
- [ ] Les images sont sauvegardées correctement
- [ ] Les images sont rechargées après sauvegarde
- [ ] L'ordre des images est conservé
- [ ] Les champs optionnels sont sauvegardés

### Étape 4 : Shortcode
- [ ] Le shortcode `[galerie_formation]` fonctionne
- [ ] Les images s'affichent en grille
- [ ] Les styles sont appliqués
- [ ] Le design est identique au HTML de référence

### Étape 5 : Styles et interactions
- [ ] Les images s'affichent en grille responsive
- [ ] L'effet zoom fonctionne au survol
- [ ] L'overlay apparaît au survol
- [ ] Le titre et la description s'affichent
- [ ] Le design est identique au HTML

## 🧪 Tests à effectuer

### Test 1 : Ajouter une image simple

1. Créez/éditez une page
2. Dans la metabox, cliquez sur "Ajouter une image"
3. Sélectionnez une image
4. Remplissez :
   - Titre : `Test Image`
   - Description : `Ceci est un test`
5. Enregistrez la page
6. Ajoutez `[galerie_formation]` dans le contenu
7. Visualisez la page

**Résultat attendu :**
- Image affichée en grille
- Effet zoom au survol
- Overlay violet au survol
- Titre et description visibles au survol

### Test 2 : Plusieurs images

1. Ajoutez 6-9 images
2. Réorganisez-les par glisser-déposer
3. Enregistrez
4. Vérifiez l'affichage

**Résultat attendu :**
- Grille de 3 colonnes (desktop)
- Images dans le bon ordre
- Effet hover sur toutes les images

### Test 3 : Catégories

1. Ajoutez plusieurs images
2. Donnez la catégorie "sketchnote" à 3 images
3. Donnez la catégorie "facilitation" aux autres
4. Utilisez les shortcodes :
   ```
   [galerie_formation category="sketchnote"]
   [galerie_formation category="facilitation"]
   ```

**Résultat attendu :**
- Première galerie : uniquement les sketchnotes
- Deuxième galerie : uniquement facilitation
- Les deux galeries distinctes

### Test 4 : Avec titres

Utilisez ce shortcode :
```
[galerie_formation
    titre="Exemples de Sketchnotes réalisés"
    sous_titre="Portfolio"
    description="Découvrez des exemples concrets"]
```

**Résultat attendu :**
- Sous-titre "Portfolio" en violet, petit
- Titre "Exemples..." en gros et gras
- Description en gris
- Galerie en dessous

### Test 5 : Colonnes

Testez différentes configurations :
```
[galerie_formation columns="2"]
[galerie_formation columns="4"]
[galerie_formation columns="5"]
```

**Résultat attendu :**
- Grille adaptée au nombre de colonnes
- Responsive fonctionnel

### Test 6 : Responsive

1. Testez sur desktop
2. Testez sur tablette (ou DevTools)
3. Testez sur mobile (ou DevTools)

**Résultat attendu :**
- **Desktop** : Grille multi-colonnes, hover fonctionne
- **Tablette** : Grille adaptative
- **Mobile** : 1 colonne, overlay toujours visible

## 🎨 Vérification du design

### Comparaison avec le HTML

Référence : `/Templates-html/formation-sketchnote.html` lignes 1105-1115

#### Éléments à vérifier

- [ ] **Grille** : Gap de 20px entre les images
- [ ] **Images** : Hauteur 300px, object-fit: cover
- [ ] **Coins** : Arrondis à 10px
- [ ] **Ombre** : Box-shadow visible
- [ ] **Hover** : Transform scale(1.05)
- [ ] **Overlay** : Gradient violet en bas
- [ ] **Texte overlay** : Blanc, en bas de l'image

### Couleurs attendues

- **Violet principal** : `#8E2183`
- **Overlay** : `rgba(142,33,131,0.9)`
- **Texte overlay** : Blanc `#fff`

## 🔧 Dépannage

### La metabox ne s'affiche pas

**Solutions :**
1. Vérifiez que le plugin est activé
2. Videz le cache
3. Vérifiez les permissions utilisateur
4. Consultez la console pour les erreurs

### La médiathèque ne s'ouvre pas

**Solutions :**
1. Vérifiez que jQuery est chargé
2. Vérifiez la console JavaScript
3. Désactivez les autres plugins
4. Vérifiez que `wp.media` est disponible

### Les styles ne s'appliquent pas

**Solutions :**
1. Videz le cache navigateur (Ctrl+F5)
2. Vérifiez que `frontend.css` est chargé
3. Vérifiez les conflits CSS
4. Inspectez les éléments dans DevTools

### L'overlay ne s'affiche pas

**Solutions :**
1. Vérifiez que le titre ou la description est rempli
2. Testez le hover (uniquement desktop)
3. Sur mobile, l'overlay doit être toujours visible
4. Vérifiez le CSS de `.gfm-gallery-overlay`

### Les images ne se sauvegardent pas

**Solutions :**
1. Vérifiez les permissions PHP
2. Vérifiez la console pour les erreurs
3. Vérifiez que le nonce est valide
4. Augmentez `max_input_vars` si beaucoup d'images

## 📱 Tests cross-browser

- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Safari iOS
- [ ] Chrome Android

## 📊 Performance

- [ ] Images en lazy loading
- [ ] Temps de chargement < 3 secondes
- [ ] Pas d'erreurs dans la console
- [ ] Grille responsive fluide

## ✨ Résultat final attendu

Après tous les tests, vous devriez avoir :

1. ✅ Un plugin galerie fonctionnel
2. ✅ Une interface admin intuitive
3. ✅ Un design identique au HTML de référence
4. ✅ Un système d'upload simple
5. ✅ Des catégories pour filtrer
6. ✅ Un effet hover professionnel
7. ✅ Un responsive parfait

## 📸 Comparaison visuelle

Comparez votre affichage avec :
`/Templates-html/formation-sketchnote.html`

Section "Exemples de Sketchnotes" (ligne 1099)

Votre galerie doit être **visuellement identique** :
- Même grille
- Même effet hover
- Même overlay
- Mêmes couleurs
- Même responsive

---

**Date de vérification :** 2025-11-09
**Version du plugin :** 1.0.0
**Statut :** ✅ Prêt pour utilisation
