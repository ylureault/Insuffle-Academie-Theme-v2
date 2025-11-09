# ✅ Guide de Vérification - Fiche Formateur Plugin

## 📋 Checklist d'installation

### Étape 1 : Activation
- [ ] Plugin activé dans WordPress
- [ ] Aucune erreur PHP affichée
- [ ] Menu "Formateurs" visible dans l'admin

### Étape 2 : Interface Admin
- [ ] Metabox "Fiche Formateur - Informations" visible sur les pages
- [ ] Metabox "Fiche Formateur - Informations" visible sur les articles
- [ ] Bouton "Choisir une photo" ouvre la médiathèque
- [ ] La photo sélectionnée s'affiche en aperçu circulaire
- [ ] Le bouton "Retirer" fonctionne
- [ ] Tous les champs texte sont éditables
- [ ] Le bouton "Ajouter un chiffre clé" fonctionne
- [ ] Les stats peuvent être réorganisées par glisser-déposer
- [ ] Le bouton de suppression des stats fonctionne

### Étape 3 : Sauvegarde
- [ ] Les données sont sauvegardées correctement
- [ ] Les données sont rechargées après sauvegarde
- [ ] L'ordre des stats est conservé
- [ ] La photo est conservée
- [ ] Tous les champs sont conservés

### Étape 4 : Shortcode
- [ ] Le shortcode `[fiche_formateur]` fonctionne
- [ ] La fiche s'affiche avec le bon design
- [ ] Les styles sont appliqués
- [ ] Le design est identique au HTML de référence

### Étape 5 : Design Frontend
- [ ] Header violet avec dégradé
- [ ] Photo circulaire avec bordure jaune
- [ ] Badge jaune affiché correctement
- [ ] Nom en gros titre blanc
- [ ] Tagline en jaune
- [ ] Description en blanc
- [ ] Section stats avec fond violet
- [ ] Chiffres en jaune, gros et gras
- [ ] Citation centrée avec guillemets
- [ ] Effet "bulle" en arrière-plan

## 🧪 Tests à effectuer

### Test 1 : Fiche formateur simple

1. Créez/éditez une page
2. Dans la metabox, remplissez :
   - **Photo** : Sélectionnez une photo
   - **Badge** : `Fondateur`
   - **Nom** : `Test Formateur`
   - **Tagline** : `Expert Test`
   - **Description** : `Ceci est un test de description`
3. Enregistrez la page
4. Ajoutez `[fiche_formateur]` dans le contenu
5. Visualisez la page

**Résultat attendu :**
- Header violet avec photo circulaire
- Badge jaune "Fondateur"
- Nom "Test Formateur" en gros titre
- Tagline "Expert Test" en jaune
- Description affichée en blanc

### Test 2 : Avec chiffres clés

1. Ajoutez 4 chiffres clés :
   - `15+` | `Années d'expérience`
   - `500+` | `Clients formés`
   - `200+` | `Entreprises`
   - `2` | `Méthodes propriétaires`
2. Réorganisez-les par glisser-déposer
3. Enregistrez
4. Vérifiez l'affichage

**Résultat attendu :**
- Section stats avec fond violet
- 4 statistiques affichées en grille
- Chiffres en jaune, gros et gras
- Labels en blanc
- Ordre respecté

### Test 3 : Avec citation

1. Ajoutez une citation :
   - **Texte** : `Le changement ne se décrète pas, il se facilite.`
   - **Auteur** : `Yoan Lureault`
2. Enregistrez
3. Vérifiez l'affichage

**Résultat attendu :**
- Section citation sur fond blanc
- Guillemets géants en jaune
- Citation en violet, italique
- Auteur en gris avec "—"

### Test 4 : Fiche complète

Remplissez tous les champs avec le contenu de fiche-formateur-yoan.html :

**Badge** : Fondateur Insuffle Académie

**Nom** : Yoan Lureault

**Tagline** : Expert en Transformation Collective

**Description** :
```
Facilitateur et stratège de la transformation organisationnelle, créateur des méthodologies
<strong>Futur Désiré®</strong> et <strong>Boussole 4C®</strong>.
15 ans d'expérience terrain à accompagner PME et ETI dans leur transformation par l'intelligence collective.
```

**Stats** :
- 15+ | Années d'expérience terrain
- 500+ | Managers formés
- 200+ | Entreprises accompagnées
- 2 | Méthodes propriétaires

**Citation** :
```
Le changement ne se décrète pas, il se facilite. Mon job n'est pas de vous dire quoi faire,
mais de révéler l'intelligence qui existe déjà dans vos équipes.
```

**Auteur** : Yoan Lureault

**Résultat attendu :**
La fiche doit être **visuellement identique** au HTML de référence.

### Test 5 : Champs optionnels

1. Créez une nouvelle page
2. Remplissez seulement :
   - Nom : `Test Minimal`
3. Enregistrez
4. Ajoutez le shortcode

**Résultat attendu :**
- Fiche affichée avec uniquement le nom
- Pas d'erreurs
- Sections vides non affichées

### Test 6 : Shortcode avec post_id

1. Notez l'ID de la page précédente (ex: 123)
2. Créez une nouvelle page
3. Ajoutez : `[fiche_formateur post_id="123"]`
4. Visualisez

**Résultat attendu :**
- Fiche du post ID 123 affichée
- Pas la fiche de la page actuelle

### Test 7 : Responsive

1. Testez sur desktop
2. Testez sur tablette (ou DevTools)
3. Testez sur mobile (ou DevTools)

**Résultat attendu :**
- **Desktop** : Layout en 2 colonnes (photo + contenu)
- **Tablette** : Layout adaptatif
- **Mobile** : Layout 1 colonne, photo centrée, stats en 2 colonnes puis 1

## 🎨 Vérification du design

### Comparaison avec le HTML

Référence : `/Templates-html/fiche-formateur-yoan.html`

#### Éléments à vérifier

- [ ] **Header** : Gradient violet (#8E2183 vers #6d1a66)
- [ ] **Photo** : Circulaire, 280px, bordure jaune 8px
- [ ] **Badge** : Fond jaune, texte violet, arrondi
- [ ] **Nom** : 3.5rem, blanc, gras (900)
- [ ] **Tagline** : 1.5rem, jaune, gras (600)
- [ ] **Description** : 1.1rem, blanc, opacity 0.95
- [ ] **Stats section** : Fond violet avec gradient
- [ ] **Stat number** : 4rem, jaune, gras (900)
- [ ] **Stat label** : 1.1rem, blanc
- [ ] **Quote icon** : 4rem, jaune, opacity 0.5
- [ ] **Quote text** : 1.5rem, violet, italique
- [ ] **Quote author** : 1.1rem, gris

### Couleurs attendues

- **Violet principal** : `#8E2183`
- **Jaune** : `#FFD466`
- **Rose** : `#FFC0CB`
- **Blanc** : `#FFFFFF`
- **Gris foncé** : `#333333`
- **Gris clair** : `#F5F5F5`

### Effets visuels

- [ ] **Bulles décoratives** : Dégradé radial jaune en arrière-plan
- [ ] **Ombre photo** : Box-shadow noir 30% opacity
- [ ] **Transitions** : Douces sur hover si applicable
- [ ] **Border-radius** : Container 30px, photo 50%, badge 20px

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
2. Vérifiez que wp.media est disponible
3. Vérifiez la console JavaScript
4. Désactivez les autres plugins

### Les styles ne s'appliquent pas

**Solutions :**
1. Videz le cache navigateur (Ctrl+F5)
2. Vérifiez que `frontend.css` est chargé
3. Vérifiez les conflits CSS
4. Inspectez les éléments dans DevTools

### Les stats ne se réorganisent pas

**Solutions :**
1. Vérifiez que jQuery UI Sortable est chargé
2. Testez le drag sur la poignée (icône menu)
3. Vérifiez la console JavaScript
4. Vérifiez que `admin.js` est chargé

### Les données ne se sauvegardent pas

**Solutions :**
1. Vérifiez les permissions PHP
2. Vérifiez la console pour les erreurs
3. Vérifiez que le nonce est valide
4. Augmentez `max_input_vars` si beaucoup de stats

## 📱 Tests cross-browser

- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Safari iOS
- [ ] Chrome Android

## 📊 Performance

- [ ] Temps de chargement < 3 secondes
- [ ] Pas d'erreurs dans la console
- [ ] Images optimisées
- [ ] CSS/JS minifiés en production

## ✨ Résultat final attendu

Après tous les tests, vous devriez avoir :

1. ✅ Un plugin formateur fonctionnel
2. ✅ Une interface admin intuitive
3. ✅ Un design identique au HTML de référence
4. ✅ Un système d'upload photo simple
5. ✅ Des chiffres clés réorganisables
6. ✅ Un système de citation élégant
7. ✅ Un responsive parfait

## 📸 Comparaison visuelle

Comparez votre affichage avec :
`/Templates-html/fiche-formateur-yoan.html`

Votre fiche doit être **visuellement identique** :
- Même gradient
- Même photo circulaire
- Même badge
- Même typo
- Mêmes couleurs
- Même responsive

---

**Date de vérification :** 2025-11-09
**Version du plugin :** 1.0.0
**Statut :** ✅ Prêt pour utilisation
