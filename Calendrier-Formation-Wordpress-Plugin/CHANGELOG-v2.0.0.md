# Calendrier Formation Plugin - Version 2.0.0

## 🎉 Système de Réservation Complet

Cette version majeure apporte un système de réservation professionnel end-to-end pour vos formations.

---

## ✨ Nouvelles Fonctionnalités

### 1. Formulaire de Réservation Frontend

**Shortcode**: `[formulaire_reservation]`

#### Caractéristiques:
- ✅ **3 sections organisées** : Informations personnelles / Entreprise / Détails
- ✅ **Champs professionnels complets**:
  - Civilité, Prénom, Nom, Email, Téléphone, Fonction
  - Raison sociale, SIRET, Adresse complète, Secteur, Taille entreprise
  - Nombre de participants, Type de prise en charge, Besoins spécifiques
- ✅ **Design moderne et rassurant**
- ✅ **100% responsive** (desktop, tablet, mobile)
- ✅ **Soumission AJAX** sans rechargement
- ✅ **Validation en temps réel**
- ✅ **Messages de confirmation clairs**
- ✅ **Conformité RGPD** (consentement obligatoire)

#### Utilisation:
Créez une page "Inscription" et ajoutez le shortcode. Le formulaire récupère automatiquement les infos de session depuis l'URL.

---

### 2. Gestion Admin des Réservations

**Menu**: `Agenda → Réservations`

#### Fonctionnalités:
- 📊 **Dashboard statistiques**: Total, En attente, Confirmées, Annulées
- 🔍 **Filtres puissants**: Par statut, recherche globale
- 📋 **Liste complète**: Toutes les réservations avec infos clés
- ✏️ **Actions rapides**:
  - Voir les détails complets
  - Confirmer une réservation en 1 clic
  - Changer le statut (pending → confirmed → cancelled)
  - Supprimer une réservation
- 📥 **Export CSV**: Export complet avec tous les champs
- 📧 **Emails automatiques**: Notification admin + confirmation client

#### Statuts disponibles:
- `pending` - En attente de validation (par défaut)
- `confirmed` - Inscription confirmée
- `cancelled` - Annulée

---

### 3. Système d'Emails Personnalisables

**Menu**: `Agenda → Templates emails`

#### 3 templates pré-configurés:

**A. Confirmation Client** (`booking_confirmation_client`)
- Envoyé automatiquement après la demande
- Infos de la session + référence unique
- Rassure le client

**B. Notification Admin** (`booking_notification_admin`)
- Envoyé à l'admin pour chaque nouvelle demande
- Toutes les infos participant + entreprise
- Lien direct vers la réservation dans l'admin

**C. Inscription Confirmée** (`booking_confirmed`)
- Envoyé quand l'admin confirme l'inscription
- Prochaines étapes détaillées
- Ton professionnel

#### Personnalisation:
- ✏️ **Édition en ligne**: Sujet + Corps
- 🎯 **Variables dynamiques**: `{{prenom}}`, `{{formation_title}}`, `{{booking_key}}`, etc.
- ✉️ **Envoi de test**: Testez avant de mettre en prod
- 🎨 **Template HTML**: Design automatique avec header/footer
- 🔄 **Activer/Désactiver**: Par template

#### Variables disponibles:
```
{{prenom}}, {{nom}}, {{email}}, {{telephone}}, {{fonction}}
{{raison_sociale}}, {{siret}}, {{adresse_complete}}
{{formation_title}}, {{session_title}}, {{date_debut}}, {{date_fin}}
{{nombre_participants}}, {{booking_key}}, {{created_at}}
... et bien d'autres
```

---

### 4. Base de Données

#### Table `wp_cf_bookings`:
- Tous les champs nécessaires pour une réservation pro
- Index optimisés pour les recherches
- Métadonnées: IP, User Agent, dates de création/mise à jour
- Clés uniques pour traçabilité

#### Table `wp_cf_email_templates`:
- Templates d'emails modifiables
- Versioning et historique
- Variables documentées

---

## 🔄 Parcours Utilisateur Complet

### Côté Client:
1. 🔍 Consulte les formations et sessions (vue cartes ou tableau)
2. 📝 Clique sur "Réserver" → Redirigé vers formulaire avec infos pré-remplies
3. ✍️ Remplit ses informations personnelles et entreprise
4. ✅ Soumet le formulaire
5. 📧 Reçoit immédiatement un email de confirmation
6. ⏳ Attend la validation de l'admin

### Côté Admin:
1. 🔔 Reçoit un email de notification avec tous les détails
2. 🖥️ Se connecte à l'admin WordPress
3. 📊 Voit les nouvelles réservations dans le dashboard
4. 👁️ Consulte les détails de la demande
5. ✅ Confirme l'inscription en 1 clic
6. 📧 Le client reçoit automatiquement l'email de confirmation
7. 📥 Peut exporter toutes les réservations en CSV

---

## 🎨 Configuration

### Étape 1: Page d'inscription
1. Créez une page WordPress (ex: "Inscription Formation")
2. Ajoutez le shortcode: `[formulaire_reservation]`
3. Publiez la page

### Étape 2: Configuration du plugin
`Réglages → Calendrier Formation`
- **Page d'inscription**: ID de la page créée ci-dessus
- **Page de contact**: Pour le bouton "+ d'infos"
- **Email admin**: Pour recevoir les notifications

### Étape 3: Personnalisez les emails
`Agenda → Templates emails`
- Éditez chaque template selon vos besoins
- Testez l'envoi avant de valider
- Variables disponibles documentées

---

## 📧 Configuration Email Recommandée

Pour un envoi optimal des emails:

1. **Plugin SMTP recommandé**: WP Mail SMTP ou Post SMTP
2. **Configurez un vrai SMTP**: Gmail, SendGrid, Mailgun, etc.
3. **Testez les envois**: Utilisez la fonction "Envoyer un test"
4. **Vérifiez les SPAM**: Premiers envois peuvent être filtrés

---

## 🚀 Utilisation Quotidienne

### Gérer les réservations:
1. Menu `Agenda → Réservations`
2. Vue d'ensemble avec filtres
3. Confirmez ou annulez en 1 clic
4. Exportez régulièrement en CSV pour suivi externe

### Modifier les emails:
1. Menu `Agenda → Templates emails`
2. Cliquez sur "Éditer"
3. Modifiez le texte (les variables restent)
4. Enregistrez

### Voir les statistiques:
- Dashboard des réservations: Vue globale
- Export CSV: Analyse détaillée dans Excel

---

## 🔐 Sécurité

- ✅ Tous les formulaires protégés par nonce
- ✅ Validation et sanitization de toutes les données
- ✅ Protection CSRF
- ✅ Stockage sécurisé des données personnelles
- ✅ Conformité RGPD (consentement + données)
- ✅ Pas d'accès direct aux fichiers PHP

---

## 🌍 Responsive & Accessible

- ✅ Mobile-first design
- ✅ Touch-friendly sur tablettes
- ✅ Adaptation automatique du layout
- ✅ Labels clairs pour lecteurs d'écran
- ✅ Contraste élevé pour accessibilité

---

## 📝 Shortcodes Disponibles

### Affichage des sessions:
```
[calendrier_formation]                    // Vue cartes (défaut)
[calendrier_formation display="table"]    // Vue tableau
[calendrier_formation limit="5"]          // Limiter à 5 sessions
[calendrier_formation show_past="oui"]    // Inclure sessions passées
```

### Formulaire de réservation:
```
[formulaire_reservation]                  // Formulaire complet
```

---

## 🐛 Dépannage

### Les emails ne partent pas?
- Vérifiez la configuration SMTP
- Testez avec un plugin SMTP
- Vérifiez le dossier SPAM

### Les réservations n'apparaissent pas?
- Vérifiez que le formulaire est bien sur la page
- Vérifiez la console JavaScript (F12)
- Vérifiez les logs Apache/PHP

### Le formulaire ne se soumet pas?
- Vérifiez que jQuery est chargé
- Pas de conflit avec d'autres plugins
- Console JavaScript pour voir les erreurs

---

## 🎯 Prochaines Évolutions (en discussion)

- Badge "Edition Spéciale" pour sessions premium
- Rappels automatiques avant la formation
- Intégration calendrier (iCal, Google Calendar)
- Signature électronique pour conventions
- Paiement en ligne (Stripe/PayPal)

---

## 📞 Support

Pour toute question ou problème:
1. Vérifiez ce fichier CHANGELOG
2. Consultez le README.md
3. Ouvrez une issue sur le dépôt GitHub

---

**Développé avec ❤️ pour offrir une expérience professionnelle et sans friction à vos clients.**

---

## Historique des Versions

### v2.0.0 - Système de Réservation (2025-01-XX)
- ✨ Formulaire de réservation complet
- ✨ Gestion admin des réservations
- ✨ Système d'emails personnalisables
- ✨ Export CSV
- ✨ Vue tableau pour sessions
- 🔧 Amélioration jauge de places avec code couleur
- 🔧 Boutons +/- pour gestion rapide des places
- 🐛 Fix double création de sessions
- 🐛 Support places illimitées

### v1.0.0 - Version Initiale
- Calendrier de sessions
- Vue liste et calendrier
- Gestion des formations
