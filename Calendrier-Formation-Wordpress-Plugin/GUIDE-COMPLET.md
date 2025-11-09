# Guide Complet - Calendrier Formation Plugin

## 📋 Table des matières

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Menu d'administration](#menu-dadministration)
4. [Shortcodes disponibles](#shortcodes-disponibles)
5. [Guide de démarrage rapide](#guide-de-démarrage-rapide)
6. [FAQ](#faq)

---

## 🎯 Introduction

**Calendrier Formation** est un plugin WordPress professionnel qui vous permet de :

- ✅ Gérer vos sessions de formation avec un calendrier interactif
- ✅ Afficher les sessions sur vos pages via des shortcodes
- ✅ Recevoir et gérer les réservations
- ✅ Envoyer des emails automatiques aux participants
- ✅ Visualiser les statistiques de vos formations

---

## 💻 Installation

### Méthode 1 : Installation manuelle

1. Téléchargez le dossier `Calendrier-Formation-Wordpress-Plugin`
2. Placez-le dans `/wp-content/plugins/`
3. Activez le plugin depuis l'interface WordPress

### Méthode 2 : Via l'interface WordPress

1. Allez dans **Extensions > Ajouter**
2. Téléversez le fichier ZIP du plugin
3. Activez le plugin

### Après activation

Le plugin créera automatiquement :
- Les tables de base de données nécessaires
- Une page "Inscription Formation" avec le formulaire de réservation
- Les templates d'emails par défaut

---

## 🎛️ Menu d'administration

Une fois activé, vous trouverez un nouveau menu **"Agenda"** dans votre interface WordPress avec les sous-menus suivants :

### 📊 Tableau de bord
- Vue d'ensemble de vos formations
- Statistiques en temps réel
- Prochaines sessions
- Actions rapides

### 📅 Calendrier
- Vue calendrier interactive (FullCalendar)
- Création rapide de sessions
- Gestion par glisser-déposer

### 📝 Sessions
- Liste de toutes vos sessions
- Création et édition de sessions
- Gestion des places disponibles

### 👥 Réservations
- Gestion des demandes d'inscription
- Confirmation/rejet des réservations
- Export des données

### 📧 Templates emails
- Personnalisation des emails automatiques
- Variables dynamiques disponibles
- Prévisualisation des emails

### 🔧 Diagnostic 404
- Outils de diagnostic
- Vérification des permaliens
- Résolution des problèmes courants

### 📖 Aide
- Documentation complète
- Guide des shortcodes
- Exemples d'utilisation

### 👁️ Aperçu
- Testeur de shortcodes en temps réel
- Prévisualisation avec vos données
- Exemples rapides à copier

### ⚙️ Paramètres
- Configuration générale
- Page parent des formations
- Page d'inscription
- Email de contact

---

## 🚀 Shortcodes disponibles

### 1. `[calendrier_formation]`

Affiche les sessions de formation disponibles.

#### Paramètres :

| Paramètre | Description | Valeur par défaut | Exemple |
|-----------|-------------|-------------------|---------|
| `post_id` | ID de la formation | Page actuelle | `post_id="123"` |
| `limit` | Nombre max de sessions | 0 (toutes) | `limit="5"` |
| `show_past` | Afficher sessions passées | non | `show_past="oui"` |
| `display` | Mode d'affichage | cards | `display="table"` |
| `debug` | Mode debug (admin) | non | `debug="oui"` |

#### Exemples :

```
[calendrier_formation]
```
Affichage simple des sessions de la page actuelle en mode cartes.

```
[calendrier_formation display="table"]
```
Affichage en mode tableau.

```
[calendrier_formation limit="3"]
```
Afficher uniquement les 3 prochaines sessions.

```
[calendrier_formation show_past="oui"]
```
Afficher toutes les sessions, y compris les sessions passées.

```
[calendrier_formation post_id="123" display="table" limit="5"]
```
Sessions de la formation ID 123, en tableau, max 5 sessions.

### 2. `[formulaire_reservation]`

Affiche le formulaire de réservation pour une session.

#### Exemple :

```
[formulaire_reservation]
```

**Note :** Ce shortcode est automatiquement ajouté à la page d'inscription lors de l'activation du plugin.

---

## 🎓 Guide de démarrage rapide

### Étape 1 : Configuration initiale

1. Allez dans **Agenda > Paramètres**
2. Définissez l'ID de votre page parent "Formations"
3. Vérifiez la page d'inscription créée automatiquement
4. Configurez l'email de contact

### Étape 2 : Créer vos pages de formation

1. Créez une page parent "Formations" (si ce n'est pas déjà fait)
2. Créez des pages enfants pour chaque formation
3. Ajoutez le shortcode `[calendrier_formation]` dans le contenu

**Exemple :**
```
Page: Formations (ID: 51)
  ├─ Formation WordPress (ID: 123)
  ├─ Formation SEO (ID: 124)
  └─ Formation Marketing Digital (ID: 125)
```

### Étape 3 : Créer des sessions

#### Méthode 1 : Via le calendrier
1. Allez dans **Agenda > Calendrier**
2. Cliquez sur une date
3. Remplissez le formulaire
4. Enregistrez

#### Méthode 2 : Via la liste
1. Allez dans **Agenda > Sessions**
2. Cliquez sur "Nouvelle session"
3. Remplissez les informations
4. Enregistrez

### Étape 4 : Tester l'affichage

1. Allez dans **Agenda > Aperçu**
2. Sélectionnez une formation dans la liste
3. Testez différents shortcodes
4. Copiez le shortcode qui vous convient

### Étape 5 : Gérer les réservations

1. Les nouvelles réservations apparaissent dans **Agenda > Réservations**
2. Vous recevez un email de notification
3. Le client reçoit un email de confirmation
4. Validez ou refusez la demande

---

## ❓ FAQ

### Comment afficher les sessions d'une formation spécifique ?

Utilisez le paramètre `post_id` :
```
[calendrier_formation post_id="123"]
```

### Comment changer l'apparence des sessions ?

Le plugin charge automatiquement des styles par défaut. Vous pouvez les personnaliser dans votre thème en surchargeant les styles CSS du plugin.

### Les sessions ne s'affichent pas, que faire ?

1. Vérifiez que vous êtes sur une page enfant de votre page "Formations"
2. Vérifiez l'ID configuré dans **Agenda > Paramètres**
3. Utilisez le mode debug : `[calendrier_formation debug="oui"]`
4. Consultez **Agenda > Diagnostic 404**

### Comment personnaliser les emails ?

1. Allez dans **Agenda > Templates emails**
2. Modifiez les templates selon vos besoins
3. Utilisez les variables disponibles (ex: `{{prenom}}`, `{{formation_title}}`)
4. Prévisualisez avant d'enregistrer

### Peut-on limiter les places disponibles ?

Oui ! Lors de la création d'une session :
1. Définissez le nombre total de places
2. Le système calcule automatiquement les places disponibles
3. Les sessions complètes sont marquées "Complet"
4. Le bouton de réservation est désactivé

### Comment exporter les réservations ?

Actuellement, vous pouvez :
1. Voir toutes les réservations dans **Agenda > Réservations**
2. Copier les informations manuellement
3. (Fonctionnalité d'export CSV à venir)

### Le plugin est-il compatible multilingue ?

Le plugin est prêt pour la traduction avec le domaine `calendrier-formation`. Vous pouvez créer vos propres fichiers de traduction dans le dossier `/languages/`.

### Comment désactiver le plugin sans perdre les données ?

Les données sont conservées dans la base de données même si vous désactivez le plugin. Lors de la réactivation, tout sera restauré.

⚠️ **Attention :** La désinstallation complète supprimera toutes les données.

---

## 🆘 Support

### En cas de problème :

1. **Consultez l'aide intégrée** : Allez dans **Agenda > Aide**
2. **Testez en mode debug** : Ajoutez `debug="oui"` à vos shortcodes
3. **Vérifiez le diagnostic** : Consultez **Agenda > Diagnostic 404**
4. **Testez dans l'aperçu** : Utilisez **Agenda > Aperçu** pour tester

### Ressources utiles :

- Documentation complète : **Agenda > Aide**
- Testeur de shortcodes : **Agenda > Aperçu**
- Guide des shortcodes : Ce document
- Diagnostic : **Agenda > Diagnostic 404**

---

## 📝 Changelog

### Version 2.0.0
- ✨ Ajout de la page d'aide intégrée
- ✨ Ajout de la page d'aperçu pour tester les shortcodes
- ✨ Amélioration du tableau de bord avec widget de bienvenue
- ✨ Amélioration de l'interface utilisateur
- 🐛 Corrections de bugs divers

---

## 📄 License

GPL v2 or later

---

## 👨‍💻 Développé par

Insuffle Académie - Formation & Développement WordPress

**Auteur :** Yoan Lureault
**GitHub :** https://github.com/ylureault

---

**Merci d'utiliser Calendrier Formation !** 🎉
