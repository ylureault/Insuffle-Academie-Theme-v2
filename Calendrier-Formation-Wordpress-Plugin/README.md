# Calendrier Formation - Plugin WordPress

Plugin WordPress pour gérer des sessions de formation sur vos pages existantes avec système de réservation et gestion des places.

## Description

Ce plugin ajoute la gestion de sessions de formation directement sur vos pages WordPress existantes. Il s'intègre parfaitement avec votre structure de pages existante :

- **Utilisez vos pages existantes** - Pas besoin de créer un nouveau type de contenu
- **Structure hiérarchique** - Toutes les pages enfants de votre page "Formations" deviennent automatiquement des pages de formation
- **Gestion illimitée** - Créez autant de sessions que vous voulez pour chaque formation
- **Système de réservation** - URLs uniques avec paramètres pour vos formulaires d'inscription
- **Gestion des places** - Suivez les places disponibles en temps réel

## Fonctionnement

### Structure des pages

Le plugin fonctionne avec une structure hiérarchique simple :

```
📄 Formations (Page parent - ID: 51)
  ├── 📄 Formation WordPress
  ├── 📄 Formation PHP
  ├── 📄 Formation React
  └── 📄 Formation Python
```

**Important :** Seules les **pages enfants directes** de la page "Formations" (ID: 51) auront la possibilité de gérer des sessions.

## Installation

### Installation manuelle

1. Téléchargez le plugin
2. Décompressez l'archive dans `/wp-content/plugins/`
3. Activez le plugin depuis le menu "Extensions" de WordPress
4. Le plugin créera automatiquement les tables de base de données nécessaires

### Via l'interface WordPress

1. Allez dans **Extensions > Ajouter**
2. Cliquez sur "Téléverser une extension"
3. Sélectionnez le fichier ZIP du plugin
4. Cliquez sur "Installer maintenant"
5. Activez le plugin

## Configuration

### 1. Paramètres du plugin

Allez dans **Réglages > Calendrier Formation** :

- **ID de la page parent** : Par défaut 51 (votre page "Formations"). Modifiez si nécessaire.
- **URL du formulaire d'inscription** : URL vers votre formulaire de contact/inscription
- **Email de notification** : Email pour recevoir les notifications de réservation

Le plugin affichera automatiquement toutes vos pages de formation détectées.

### 2. Créer des sessions sur une formation existante

1. Allez dans **Pages** dans votre admin WordPress
2. Éditez une page enfant de votre page "Formations"
3. Vous verrez une nouvelle section **"Sessions de formation"**
4. Cliquez sur **"Ajouter une session"**
5. Remplissez les informations :
   - Titre de la session
   - Date et heure de début
   - Date et heure de fin
   - Durée (calculée automatiquement)
   - Type : À distance ou En présentiel
   - Adresse (si présentiel)
   - Nombre de places total
   - Places disponibles
   - Statut (active/inactive)
6. Cliquez sur **"Enregistrer"**
7. Mettez à jour la page

### 3. Afficher les sessions sur votre page

Ajoutez simplement le shortcode dans le contenu de votre page :

```
[calendrier_formation]
```

Les sessions s'afficheront automatiquement avec un design moderne.

## Utilisation du shortcode

### Shortcode de base

```
[calendrier_formation]
```

Affiche toutes les sessions de la page courante (futures uniquement).

### Options disponibles

#### Afficher les sessions d'une formation spécifique

```
[calendrier_formation post_id="123"]
```

#### Limiter le nombre de sessions

```
[calendrier_formation limit="5"]
```

#### Afficher aussi les sessions passées

```
[calendrier_formation show_past="oui"]
```

#### Combiner plusieurs options

```
[calendrier_formation post_id="123" limit="3" show_past="non"]
```

## Fonctionnalités

### ✅ Gestion des sessions

- Créez autant de sessions que vous voulez par formation
- Dates de début/fin avec calcul automatique de la durée
- Type de formation : À distance ou En présentiel
- Gestion du nombre de places (total + disponibles)
- Statut actif/inactif
- Interface AJAX moderne (pas de rechargement de page)

### ✅ Affichage frontend

- Design moderne et responsive
- Cartes de session élégantes avec animations
- Badges de statut (disponible, places limitées, complet)
- Barre de progression des places restantes
- Fonctionne sur mobile, tablette et desktop

### ✅ Système de réservation

Quand un utilisateur clique sur "Réserver ma place", il est redirigé vers votre formulaire avec ces paramètres dans l'URL :

- `session_id` : ID unique de la session
- `formation_id` : ID de la page formation
- `formation` : Titre de la formation
- `session` : Titre de la session
- `date_debut` : Date de début (format : Y-m-d H:i)
- `date_fin` : Date de fin
- `duree` : Durée de la formation
- `type_location` : "distance" ou "lieu"
- `location` : Adresse si en présentiel
- `booking_key` : Clé unique de réservation

**Exemple d'URL générée :**
```
https://votresite.com/inscription/?session_id=5&formation=WordPress%20Avancé&date_debut=2024-03-15%2009:00&...
```

### ✅ Administration WordPress

#### Vue d'ensemble des sessions

- Menu **Pages > Sessions de formation** : Vue globale de toutes les sessions
- Liste des pages avec colonnes personnalisées :
  - Nombre de sessions par page
  - Prochaine session à venir
  - Places disponibles

#### Gestion des réservations

- Menu **Pages > Réservations** : Vue de toutes les réservations
- Changement de statut en un clic (en attente / confirmée / annulée)
- Informations complètes des participants
- Liens directs vers les formations

#### Statistiques

Page **Réglages > Calendrier Formation** affiche :
- Sessions totales actives
- Sessions à venir
- Réservations totales
- Réservations en attente

## Intégration avec un formulaire

Le fichier `EXEMPLE-FORMULAIRE.php` contient des exemples complets pour :

- Créer un formulaire HTML personnalisé avec champs pré-remplis
- Traiter les inscriptions et décrémenter les places
- Intégrer avec Contact Form 7, Gravity Forms, WPForms, etc.
- Envoyer des emails de confirmation

### Exemple rapide : Récupérer les paramètres en JavaScript

```javascript
const urlParams = new URLSearchParams(window.location.search);
const sessionId = urlParams.get('session_id');
const formationName = urlParams.get('formation');
const dateDebut = urlParams.get('date_debut');

// Pré-remplir vos champs
document.getElementById('formation').value = formationName;
document.getElementById('session_id').value = sessionId;
```

### Exemple rapide : Récupérer les paramètres en PHP

```php
$session_id = isset($_GET['session_id']) ? intval($_GET['session_id']) : 0;
$formation = isset($_GET['formation']) ? sanitize_text_field($_GET['formation']) : '';
$date_debut = isset($_GET['date_debut']) ? sanitize_text_field($_GET['date_debut']) : '';
```

## Structure de la base de données

### Table `wp_cf_sessions`

Stocke toutes les sessions de formation :

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint(20) | ID unique de la session |
| post_id | bigint(20) | ID de la page WordPress |
| session_title | varchar(255) | Titre de la session |
| date_debut | datetime | Date/heure de début |
| date_fin | datetime | Date/heure de fin |
| duree | varchar(100) | Durée formatée |
| type_location | varchar(50) | "distance" ou "lieu" |
| location_details | text | Adresse du lieu |
| places_total | int(11) | Nombre total de places |
| places_disponibles | int(11) | Places restantes |
| status | varchar(20) | "active" ou "inactive" |

### Table `wp_cf_bookings`

Stocke les réservations :

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint(20) | ID unique de la réservation |
| session_id | bigint(20) | ID de la session |
| nom | varchar(255) | Nom du participant |
| prenom | varchar(255) | Prénom du participant |
| email | varchar(255) | Email du participant |
| telephone | varchar(50) | Téléphone (optionnel) |
| entreprise | varchar(255) | Entreprise (optionnel) |
| message | text | Message (optionnel) |
| status | varchar(20) | "pending", "confirmed" ou "cancelled" |
| booking_key | varchar(100) | Clé unique de réservation |

## Personnalisation

### CSS personnalisé

Vous pouvez surcharger les styles dans votre thème :

```css
/* Personnaliser les couleurs des cartes */
.cf-session-card-header {
    background: linear-gradient(135deg, #votre-couleur1 0%, #votre-couleur2 100%);
}

/* Personnaliser les boutons */
.cf-btn-primary {
    background: #votre-couleur;
}
```

### Classes CSS disponibles

- `.cf-sessions-container` : Container principal
- `.cf-session-card` : Carte de session
- `.cf-session-card-header` : En-tête de la carte
- `.cf-btn-primary` : Bouton de réservation
- `.cf-badge` : Badge de statut

## FAQ

**Q: Comment changer l'ID de la page parent ?**

R: Allez dans Réglages > Calendrier Formation et modifiez le champ "ID de la page parent".

**Q: Les sessions n'apparaissent pas sur ma page**

R: Vérifiez que :
1. La page est bien une page enfant directe de la page "Formations" (ID: 51)
2. Vous avez bien ajouté le shortcode `[calendrier_formation]`
3. Des sessions actives existent pour cette page
4. Les dates des sessions ne sont pas passées

**Q: Puis-je utiliser plusieurs pages parents ?**

R: Non, actuellement une seule page parent est supportée. Toutes vos formations doivent être des pages enfants de cette page.

**Q: Comment récupérer les paramètres dans mon formulaire ?**

R: Consultez le fichier `EXEMPLE-FORMULAIRE.php` qui contient tous les exemples nécessaires (JavaScript, PHP, Contact Form 7, etc.)

**Q: Les sessions se suppriment toutes seules ?**

R: Non, les sessions sont permanentes. Vous devez les supprimer manuellement ou changer leur statut en "inactive".

## Structure du plugin

```
calendrier-formation/
├── calendrier-formation.php          # Fichier principal
├── includes/
│   ├── class-sessions-manager.php    # Gestionnaire des sessions
│   ├── class-sessions-meta.php       # Meta box pour l'édition
│   ├── class-settings.php            # Page de paramètres
│   ├── class-shortcode.php           # Shortcode [calendrier_formation]
│   └── class-booking-handler.php     # Gestion des réservations
├── assets/
│   ├── css/
│   │   ├── frontend.css              # Styles frontend
│   │   └── admin.css                 # Styles admin
│   └── js/
│       ├── frontend.js               # Scripts frontend
│       └── admin.js                  # Scripts admin
├── README.md                         # Ce fichier
├── EXEMPLE-FORMULAIRE.php            # Exemples d'intégration
└── LICENSE                           # Licence GPL v2
```

## Support

Pour toute question ou problème :

- Consultez d'abord ce README et le fichier `EXEMPLE-FORMULAIRE.php`
- Vérifiez les paramètres dans Réglages > Calendrier Formation
- Créez une issue sur GitHub si le problème persiste

## Changelog

### Version 1.0.0
- Version initiale du plugin
- Gestion complète des sessions sur pages existantes
- Shortcode d'affichage
- Système de réservation avec URL unique
- Interface admin moderne
- Page de statistiques
- Support des pages hiérarchiques WordPress

## Auteur

Développé avec WordPress et beaucoup de café ☕

## Licence

GPL v2 or later

---

**Requis :** WordPress 5.0+ et PHP 7.4+
