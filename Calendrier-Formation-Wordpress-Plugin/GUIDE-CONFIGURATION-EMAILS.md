# Guide de Configuration des Emails - Calendrier Formation

## 📧 Vue d'ensemble

Le plugin Calendrier Formation dispose d'un système complet de gestion des emails avec templates personnalisables. Ce guide vous explique comment configurer et personnaliser les emails envoyés automatiquement lors des réservations.

---

## 🎯 Types d'emails disponibles

Le système envoie **3 types d'emails** différents :

### 1. **Email de confirmation client** (`booking_confirmation_client`)
- **Quand ?** Envoyé automatiquement au client dès qu'il soumet le formulaire de réservation
- **À qui ?** Au client (email saisi dans le formulaire)
- **Objectif ?** Confirmer la réception de sa demande d'inscription

### 2. **Email de notification admin** (`booking_notification_admin`)
- **Quand ?** Envoyé automatiquement à l'administrateur dès qu'une nouvelle demande arrive
- **À qui ?** À l'administrateur du site
- **Objectif ?** Informer l'admin qu'une nouvelle demande nécessite un traitement

### 3. **Email de confirmation d'inscription** (`booking_confirmed`)
- **Quand ?** Envoyé manuellement par l'admin après validation de la réservation
- **À qui ?** Au client
- **Objectif ?** Confirmer officiellement que l'inscription est validée

---

## ⚙️ Accéder aux templates d'emails

1. **Connectez-vous** à l'admin WordPress
2. Allez dans le menu **Agenda** (dans la barre latérale)
3. Cliquez sur **Templates emails**

Vous verrez la liste des 3 templates avec leur statut (Actif/Inactif).

---

## ✏️ Modifier un template d'email

### Étape 1 : Éditer le template

1. Dans la liste des templates, cliquez sur **Éditer** pour le template que vous souhaitez modifier
2. Vous verrez deux champs principaux :
   - **Sujet de l'email** : Le titre de l'email (ligne "Objet")
   - **Corps de l'email** : Le contenu complet de l'email

### Étape 2 : Utiliser les variables

Les **variables** sont des codes entre accolades doubles `{{variable}}` qui sont automatiquement remplacés par les vraies données lors de l'envoi.

#### Variables disponibles pour TOUS les templates :

```
{{prenom}}              - Prénom du client
{{nom}}                 - Nom du client
{{email}}               - Email du client
{{telephone}}           - Téléphone
{{fonction}}            - Fonction dans l'entreprise
{{civilite}}            - Civilité (M., Mme, Autre)

{{raison_sociale}}      - Nom de l'entreprise
{{siret}}               - Numéro SIRET
{{adresse_complete}}    - Adresse complète (rue + CP + ville + pays)
{{code_postal}}         - Code postal
{{ville}}               - Ville
{{pays}}                - Pays
{{secteur_activite}}    - Secteur d'activité
{{taille_entreprise}}   - Taille de l'entreprise

{{formation_title}}     - Nom de la formation
{{session_title}}       - Nom de la session
{{date_debut}}          - Date de début (format : JJ/MM/AAAA)
{{date_fin}}            - Date de fin (format : JJ/MM/AAAA)
{{duree}}               - Durée de la formation
{{localisation}}        - Lieu ou "À distance"

{{nombre_participants}} - Nombre de participants
{{besoins_specifiques}} - Besoins spécifiques mentionnés
{{commentaires}}        - Commentaires du client

{{booking_key}}         - Référence unique de la réservation
{{created_at}}          - Date de la demande
{{admin_url}}           - Lien vers la réservation dans l'admin (pour emails admin)
{{site_name}}           - Nom de votre site
{{site_url}}            - URL de votre site
```

### Étape 3 : Exemple de personnalisation

**AVANT (template par défaut) :**
```
Bonjour {{prenom}},

Nous avons bien reçu votre demande d'inscription pour la formation :
{{formation_title}}
Session : {{session_title}}
```

**APRÈS (personnalisé) :**
```
Bonjour {{prenom}} {{nom}},

Merci pour votre intérêt ! 🎓

Nous avons bien reçu votre demande d'inscription pour :
📚 Formation : {{formation_title}}
📅 Session : {{session_title}}
🗓️ Du {{date_debut}} au {{date_fin}}
📍 Lieu : {{localisation}}

Référence de votre demande : {{booking_key}}

Notre équipe va traiter votre demande dans les plus brefs délais.

À très bientôt,
L'équipe {{site_name}}
```

### Étape 4 : Sauvegarder

1. Cliquez sur **Enregistrer**
2. Le template est maintenant actif avec vos modifications

---

## 🧪 Tester un email

Avant d'activer un template, vous pouvez l'envoyer en test :

1. **Éditez** le template que vous voulez tester
2. Cliquez sur le bouton **Envoyer un test** (icône email)
3. Une fenêtre apparaît vous demandant **une adresse email**
4. Entrez votre adresse email de test
5. Cliquez **OK**
6. Vous recevrez l'email avec des données de test

**Important :** L'email de test utilise des données fictives mais garde la mise en forme exacte que vos clients recevront.

---

## 📮 Configuration de l'email expéditeur

Par défaut, les emails sont envoyés depuis l'email configuré dans les paramètres WordPress.

### Pour modifier l'email expéditeur :

1. Allez dans **Agenda** → **Réglages**
2. Cherchez le champ **Email administrateur**
3. Entrez l'email à utiliser comme expéditeur
4. **Enregistrez**

Cet email sera utilisé pour :
- Envoyer les confirmations aux clients
- Recevoir les notifications admin

---

## 🚨 Problèmes courants et solutions

### ❌ Les emails ne sont pas reçus

**Causes possibles :**

1. **Serveur mail non configuré**
   - WordPress utilise la fonction PHP `mail()` par défaut
   - Sur certains hébergements, cette fonction est désactivée

   **Solution :** Installez un plugin SMTP comme :
   - **WP Mail SMTP** (recommandé)
   - **Easy WP SMTP**
   - **Post SMTP**

2. **Emails dans les SPAM**
   - Les emails WordPress sont souvent marqués comme spam

   **Solution :**
   - Configurez un SMTP authentifié (Gmail, SendGrid, Amazon SES, etc.)
   - Ajoutez un SPF/DKIM à votre domaine

3. **Email expéditeur invalide**
   - L'email expéditeur doit être valide et du même domaine que votre site

   **Solution :**
   - Utilisez un email de type `contact@votredomaine.com`
   - Évitez les emails gratuits (gmail.com, yahoo.fr, etc.)

### ❌ Les variables ne sont pas remplacées

**Cause :** Vous avez peut-être fait une faute de frappe dans la variable

**Solution :**
- Vérifiez que la variable est bien entre doubles accolades : `{{prenom}}` et non `{prenom}` ou `{{prénom}}`
- Référez-vous à la liste complète des variables disponibles (affichée sous le champ de texte lors de l'édition)

### ❌ L'email de confirmation admin ne fonctionne pas

**Cause :** L'email admin n'est pas configuré

**Solution :**
1. Allez dans **Agenda** → **Réglages**
2. Renseignez le champ **Email administrateur**
3. Enregistrez

---

## 🎨 Personnalisation avancée (HTML)

Les templates supportent le HTML de base. Vous pouvez utiliser :

- `<strong>Texte en gras</strong>`
- `<em>Texte en italique</em>`
- `<br>` pour un saut de ligne
- `<a href="URL">Lien</a>`
- `<ul><li>Liste</li></ul>`

**Exemple avec HTML :**
```html
<strong>Bonjour {{prenom}} {{nom}},</strong><br><br>

Nous avons bien reçu votre demande pour :<br>
<strong>{{formation_title}}</strong><br><br>

<strong>Détails :</strong><br>
📅 Du {{date_debut}} au {{date_fin}}<br>
📍 {{localisation}}<br>
👥 Nombre de participants : {{nombre_participants}}<br><br>

Référence : <strong>{{booking_key}}</strong><br><br>

<a href="{{site_url}}">Retour sur notre site</a>
```

**Note :** Le système ajoute automatiquement un design professionnel (en-tête avec gradient violet, mise en page centrée, footer) autour de votre contenu.

---

## 📊 Workflow complet des emails

Voici le flux complet lors d'une réservation :

```
1. CLIENT remplit le formulaire sur le site
   ↓
2. Formulaire soumis (AJAX)
   ↓
3. Réservation créée en BDD (statut: "pending")
   ↓
4. 📧 EMAIL 1 : Confirmation envoyée au CLIENT
   ↓
5. 📧 EMAIL 2 : Notification envoyée à l'ADMIN
   ↓
6. ADMIN se connecte et voit la demande dans "Agenda → Réservations"
   ↓
7. ADMIN clique sur "Confirmer" pour valider l'inscription
   ↓
8. Statut passe de "pending" à "confirmed"
   ↓
9. 📧 EMAIL 3 : Confirmation officielle envoyée au CLIENT
```

---

## 📋 Checklist avant mise en production

- [ ] Tester l'envoi de chacun des 3 templates avec le bouton "Envoyer un test"
- [ ] Vérifier que tous les emails arrivent bien (pas dans spam)
- [ ] Configurer un plugin SMTP si les emails ne partent pas
- [ ] Personnaliser les sujets des emails pour refléter votre marque
- [ ] Personnaliser les corps d'emails avec votre ton/style
- [ ] Vérifier que l'email expéditeur est correct (Agenda → Réglages)
- [ ] Tester une réservation complète de bout en bout
- [ ] Vérifier que l'admin reçoit bien la notification
- [ ] Confirmer une réservation et vérifier que le client reçoit l'email de confirmation

---

## 🆘 Support

Si vous rencontrez des difficultés :

1. **Vérifiez les logs WordPress** : Allez dans Outils → Santé du site → Infos → Serveur
2. **Testez avec un plugin SMTP** : Installez WP Mail SMTP pour diagnostiquer
3. **Consultez les templates par défaut** : Les templates installés à l'activation sont fonctionnels, vous pouvez les réinitialiser si besoin

---

## 📝 Notes importantes

- Les emails sont envoyés en **HTML** avec mise en forme automatique
- Tous les emails incluent automatiquement un en-tête avec le nom de votre site
- Le footer inclut le copyright automatiquement
- Les données sont protégées selon les normes **RGPD**
- Vous pouvez **désactiver** un template en décochant "Template actif" lors de l'édition

---

## ✅ Résumé

1. **Accès** : Agenda → Templates emails
2. **Édition** : Cliquez sur "Éditer" pour un template
3. **Variables** : Utilisez `{{variable}}` pour insérer des données dynamiques
4. **Test** : Utilisez le bouton "Envoyer un test"
5. **SMTP** : Installez un plugin SMTP pour garantir la délivrabilité
6. **Configuration** : Définissez l'email admin dans Agenda → Réglages

Vos emails sont maintenant entièrement personnalisables ! 🎉
