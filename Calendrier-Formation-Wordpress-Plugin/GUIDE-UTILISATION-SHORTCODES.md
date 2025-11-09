# Guide d'utilisation des Shortcodes - Calendrier Formation

## 📌 Vue d'ensemble

Le plugin Calendrier Formation offre **2 shortcodes principaux** pour afficher vos formations et gérer les réservations.

---

## 🎴 Shortcode 1 : Affichage des sessions

### Shortcode de base

```
[calendrier_formation]
```

Ce shortcode affiche toutes les sessions de formation disponibles **en mode cartes** (par défaut).

---

## 🎨 Modes d'affichage disponibles

### 1. Mode CARTES (par défaut)

**Shortcode :**
```
[calendrier_formation display="cards"]
```

ou simplement :
```
[calendrier_formation]
```

**Rendu :**
- Affichage en grille responsive (cartes)
- Design moderne avec dégradés violets
- Chaque session a sa propre carte
- Animations au scroll
- Idéal pour **2 à 10 sessions**

**Avantages :**
- ✅ Visuellement attractif
- ✅ Responsive (s'adapte automatiquement sur mobile)
- ✅ Facile à scanner visuellement
- ✅ Affiche toutes les informations de façon espacée

**Exemple d'utilisation :**
- Page de détail d'une formation spécifique
- Liste courte de sessions

---

### 2. Mode TABLEAU ⭐ NOUVEAU

**Shortcode :**
```
[calendrier_formation display="table"]
```

**Rendu :**
- Affichage en tableau compact
- Colonnes : Session | Date début | Date fin | Durée | Localisation | Places | Actions
- Tri possible par colonne
- Idéal pour **nombreuses sessions** (10+)

**Avantages :**
- ✅ Vue condensée et compacte
- ✅ Permet de comparer rapidement plusieurs sessions
- ✅ Meilleure pour les listes longues
- ✅ Tri et filtrage faciles
- ✅ Se transforme automatiquement en cartes sur mobile

**Exemple d'utilisation :**
- Page "Toutes nos sessions"
- Calendrier global de formations
- Listing avec beaucoup de dates

---

## 📋 Paramètres disponibles

Le shortcode `[calendrier_formation]` accepte plusieurs paramètres optionnels :

### Paramètre `display`
**Type :** `cards` ou `table`
**Par défaut :** `cards`
**Description :** Mode d'affichage (cartes ou tableau)

**Exemples :**
```
[calendrier_formation display="cards"]
[calendrier_formation display="table"]
```

---

### Paramètre `post_id`
**Type :** Numéro (ID de la page)
**Par défaut :** ID de la page actuelle
**Description :** Affiche les sessions d'une formation spécifique

**Exemple :**
```
[calendrier_formation post_id="123"]
```
Affiche uniquement les sessions de la formation ID 123.

---

### Paramètre `limit`
**Type :** Numéro
**Par défaut :** `0` (pas de limite)
**Description :** Limite le nombre de sessions affichées

**Exemples :**
```
[calendrier_formation limit="3"]
[calendrier_formation display="table" limit="10"]
```

**Utilisation :**
- Afficher uniquement les 3 prochaines sessions
- Créer une section "Sessions à venir" dans la homepage

---

### Paramètre `show_past`
**Type :** `oui` ou `non`
**Par défaut :** `non`
**Description :** Afficher ou non les sessions passées

**Exemples :**
```
[calendrier_formation show_past="oui"]
[calendrier_formation display="table" show_past="oui"]
```

**Utilisation :**
- Afficher l'historique des formations
- Créer une page "Formations réalisées"

---

### Paramètre `debug`
**Type :** `oui` ou `non`
**Par défaut :** `non`
**Description :** Affiche les informations de débogage (réservé aux administrateurs)

**Exemple :**
```
[calendrier_formation debug="oui"]
```

**Affiche :**
- ID de la page actuelle
- ID du parent
- Nombre de sessions en BDD
- Sessions actives
- Informations de configuration

⚠️ **Attention :** Visible uniquement par les administrateurs connectés.

---

## 🎯 Exemples d'utilisation combinés

### Exemple 1 : Tableau avec limite
```
[calendrier_formation display="table" limit="10"]
```
Affiche les 10 prochaines sessions en mode tableau.

---

### Exemple 2 : Cartes sans limite
```
[calendrier_formation display="cards"]
```
Affiche toutes les sessions futures en mode cartes.

---

### Exemple 3 : Historique en tableau
```
[calendrier_formation display="table" show_past="oui"]
```
Affiche toutes les sessions (passées ET futures) en mode tableau.

---

### Exemple 4 : Aperçu homepage (3 sessions)
```
[calendrier_formation limit="3" display="cards"]
```
Affiche les 3 prochaines sessions en mode cartes (idéal pour une homepage).

---

## 📝 Shortcode 2 : Formulaire de réservation

### Shortcode

```
[formulaire_reservation]
```

**Description :**
Ce shortcode affiche le formulaire professionnel de réservation de formation.

**Fonctionnement :**
1. Récupère automatiquement les paramètres de session depuis l'URL (quand on clique sur "Réserver")
2. Affiche un récapitulatif de la session sélectionnée
3. Affiche le formulaire complet en 3 sections :
   - Section 1 : Informations personnelles
   - Section 2 : Informations entreprise
   - Section 3 : Détails de la demande
4. Soumet les données en AJAX (sans recharger la page)
5. Envoie automatiquement les emails

**Où placer ce shortcode :**
- Le plugin crée automatiquement une page **"Inscription Formation"** lors de l'activation
- Cette page contient déjà le shortcode `[formulaire_reservation]`
- **Ne dupliquez pas** cette page, utilisez celle créée automatiquement

**Si vous devez recréer la page :**
1. Créez une nouvelle page WordPress
2. Titre : "Inscription Formation" (ou autre)
3. Contenu : `[formulaire_reservation]`
4. Publiez
5. Allez dans **Agenda → Réglages**
6. Configurez l'URL de cette page dans "URL du formulaire d'inscription"

---

## 🔧 Configuration requise

### Pour le shortcode `[calendrier_formation]`

1. **Page parent Formations** doit être configurée :
   - Allez dans **Agenda → Réglages**
   - Renseignez **"ID de la page parent Formations"**
   - Par défaut : page ID 51

2. **Sessions actives** doivent exister :
   - Créez des sessions dans **Agenda → Agenda**
   - Statut : Actif
   - Date de début dans le futur

3. **Page de réservation** doit exister :
   - Créée automatiquement à l'activation
   - Vérifiable dans **Agenda → Réglages**

---

### Pour le shortcode `[formulaire_reservation]`

1. **Tables de base de données** créées (automatique à l'activation)
2. **Templates d'emails** configurés (voir GUIDE-CONFIGURATION-EMAILS.md)
3. **Email admin** configuré dans **Agenda → Réglages**

---

## 🎨 Personnalisation CSS

Les shortcodes utilisent des classes CSS personnalisables :

### Classes pour mode CARTES

```css
.cf-sessions-container       /* Container principal */
.cf-sessions-grid            /* Grille de cartes */
.cf-session-card             /* Une carte */
.cf-session-card-header      /* En-tête de carte */
.cf-session-card-body        /* Corps de carte */
.cf-session-card-footer      /* Pied de carte */
.cf-btn-primary              /* Bouton "Réserver ma place" */
```

### Classes pour mode TABLEAU

```css
.cf-sessions-table-view      /* Container du tableau */
.cf-sessions-table-display   /* Table */
.cf-location-badge           /* Badge de localisation */
.cf-places-indicator         /* Indicateur de places */
.cf-btn-table                /* Boutons dans le tableau */
```

**Exemple de personnalisation :**
```css
/* Changer la couleur du bouton Réserver */
.cf-btn-primary {
    background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%) !important;
}

/* Changer la couleur de l'en-tête des cartes */
.cf-session-card-header {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
}
```

Ajoutez ce CSS dans :
- **Apparence → Personnaliser → CSS Additionnel**
- Ou dans votre fichier `style.css` du thème enfant

---

## 📱 Responsive et mobile

Les deux modes d'affichage sont **100% responsive** :

### Mode CARTES
- Desktop : Grille à 2-3 colonnes
- Tablette : Grille à 2 colonnes
- Mobile : 1 colonne (pleine largeur)

### Mode TABLEAU
- Desktop : Tableau classique 7 colonnes
- Tablette : Tableau avec scroll horizontal
- Mobile : **Se transforme automatiquement en cartes** (design adapté)

⚠️ **Sur mobile, le tableau devient des cartes** pour une meilleure lisibilité.

---

## ❓ Questions fréquentes

### Q : Peut-on utiliser les deux shortcodes sur la même page ?
**R :** Oui, mais ce n'est pas recommandé. Utilisez soit `display="cards"` soit `display="table"`, pas les deux.

### Q : Comment choisir entre mode cartes et mode tableau ?
**R :**
- **Cartes** : Moins de 10 sessions, design visuel important
- **Tableau** : Plus de 10 sessions, besoin de comparer rapidement

### Q : Les sessions passées s'affichent toujours
**R :** Par défaut, seules les sessions futures sont affichées. Vérifiez le paramètre `show_past="non"` (par défaut).

### Q : Le shortcode affiche "Aucune session programmée"
**R :** Vérifiez que :
- Les sessions existent dans **Agenda → Agenda**
- Les sessions ont le statut **Actif**
- Les dates de début sont **dans le futur**
- Vous êtes sur une **page enfant de la page Formations**

### Q : Comment afficher les sessions sur la page d'accueil ?
**R :**
1. Créez une section dans votre page d'accueil
2. Ajoutez le shortcode : `[calendrier_formation limit="3" display="cards"]`
3. Cela affichera les 3 prochaines sessions en cartes

### Q : Le bouton "Réserver ma place" ne fonctionne pas
**R :** Vérifiez que :
- La page "Inscription Formation" existe
- Le shortcode `[formulaire_reservation]` est présent sur cette page
- L'URL est configurée dans **Agenda → Réglages** → "URL du formulaire d'inscription"

---

## 🚀 Exemples de pages types

### Page : "Toutes nos formations"
```
[calendrier_formation display="table" show_past="non"]
```

### Page : "Prochaines sessions"
```
[calendrier_formation display="cards" limit="6"]
```

### Page : "Formation WordPress Avancé" (détail)
```
[calendrier_formation display="cards"]
```
(Le `post_id` est automatiquement détecté)

### Page : "Historique"
```
[calendrier_formation display="table" show_past="oui"]
```

### Homepage (extrait)
```html
<h2>Nos prochaines formations</h2>
[calendrier_formation limit="3" display="cards"]
<a href="/formations">Voir toutes les formations →</a>
```

---

## ✅ Checklist avant mise en ligne

- [ ] Shortcode `[calendrier_formation]` placé sur les bonnes pages
- [ ] Mode d'affichage choisi (cards ou table) selon le contexte
- [ ] Page "Inscription Formation" créée avec `[formulaire_reservation]`
- [ ] URL du formulaire configurée dans **Agenda → Réglages**
- [ ] Sessions de test créées et actives
- [ ] Test de réservation complet (du clic "Réserver" à la réception des emails)
- [ ] Responsive testé sur mobile/tablette
- [ ] Personnalisation CSS ajoutée si nécessaire

---

## 📚 Documentation complémentaire

- **GUIDE-CONFIGURATION-EMAILS.md** : Configuration des templates d'emails
- **CHANGELOG-v2.0.0.md** : Liste complète des fonctionnalités v2.0.0
- **TEST-CHECKLIST.md** : Checklist de tests avant mise en production

---

## 🎉 Résumé

| Shortcode | Usage | Exemple |
|-----------|-------|---------|
| `[calendrier_formation]` | Affiche les sessions (mode cartes) | Page formation détail |
| `[calendrier_formation display="table"]` | Affiche les sessions (mode tableau) | Page "Toutes les sessions" |
| `[calendrier_formation limit="3"]` | Limite à 3 sessions | Homepage |
| `[formulaire_reservation]` | Formulaire de réservation | Page "Inscription" |

Vous avez maintenant tous les outils pour afficher vos formations de manière professionnelle ! 🚀
