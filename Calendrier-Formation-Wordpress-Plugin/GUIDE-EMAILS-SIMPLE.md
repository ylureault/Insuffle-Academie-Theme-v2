# 📧 Configuration Emails - Guide Simple en 3 Étapes

## ⚡ RÉSUMÉ RAPIDE

**Pour que les emails fonctionnent, il faut:**
1. Installer un plugin SMTP
2. Configurer le plugin SMTP
3. Personnaliser les templates d'emails dans WordPress

**Temps nécessaire: 10 minutes**

---

## 🔧 ÉTAPE 1: Installer WP Mail SMTP (OBLIGATOIRE)

### Pourquoi ?
Par défaut, WordPress utilise la fonction PHP `mail()` qui:
- ❌ Ne fonctionne pas sur la plupart des hébergements
- ❌ Les emails vont dans les SPAM
- ❌ Les emails ne partent pas du tout

**Solution:** Utiliser un vrai serveur d'emails (SMTP)

### Comment ?

1. **Allez dans WordPress:**
   - Cliquez sur **Plugins** → **Ajouter**

2. **Cherchez:**
   - Tapez `WP Mail SMTP` dans la barre de recherche
   - Trouvez le plugin "WP Mail SMTP by WPForms"

3. **Installez:**
   - Cliquez sur **Installer**
   - Cliquez sur **Activer**

4. **Vous êtes redirigé vers la configuration**

---

## ⚙️ ÉTAPE 2: Configurer WP Mail SMTP

### Option A: Avec Gmail (RECOMMANDÉ pour débutants)

1. **Dans WP Mail SMTP, choisissez "Google / Gmail"**

2. **Remplissez:**
   - **From Email:** `votre-email@gmail.com`
   - **From Name:** `Nom de votre organisme`
   - **Return Path:** Cochez la case

3. **Configuration OAuth:**
   - Cliquez sur **Create a Project** (le plugin vous guide)
   - Suivez les étapes pour autoriser Gmail
   - Copiez/collez les clés API

4. **Testez:**
   - Allez dans l'onglet **Email Test**
   - Envoyez un email de test à vous-même
   - Vérifiez que vous le recevez

**✅ Si vous recevez l'email de test → C'est bon !**

---

### Option B: Avec un autre service

**Autres services populaires:**
- **SendGrid** (gratuit jusqu'à 100 emails/jour)
- **Mailgun** (gratuit jusqu'à 5000 emails/mois)
- **Amazon SES** (pas cher, pour gros volumes)
- **Outlook/Office 365** (si vous avez un compte professionnel)

**Configuration générale SMTP:**
1. Dans WP Mail SMTP, choisissez **"Other SMTP"**
2. Remplissez:
   - **SMTP Host:** smtp.votrefournisseur.com
   - **SMTP Port:** 587 (ou 465)
   - **Encryption:** TLS (ou SSL)
   - **Authentication:** ON
   - **SMTP Username:** votre email
   - **SMTP Password:** votre mot de passe

3. **Testez** avec l'onglet Email Test

---

## 📝 ÉTAPE 3: Configurer les Templates dans WordPress

Une fois que WP Mail SMTP fonctionne, configurez vos templates :

### 1. Accédez aux templates

Allez dans **Agenda** → **Templates emails**

Vous voyez 3 templates:
- **Confirmation de réservation - Client**
- **Nouvelle réservation - Admin**
- **Réservation confirmée - Client**

### 2. Éditez chaque template

**Pour chaque template:**

1. Cliquez sur **Éditer**

2. **Modifiez le sujet:**
   ```
   Exemple: Confirmation - Formation {{formation_title}}
   ```

3. **Modifiez le corps:**
   ```
   Bonjour {{prenom}},

   Nous avons bien reçu votre demande d'inscription pour :

   📚 Formation: {{formation_title}}
   📅 Dates: du {{date_debut}} au {{date_fin}}
   📍 Lieu: {{localisation}}

   Nous vous recontacterons sous 48h.

   Cordialement,
   L'équipe formation
   ```

4. **Utilisez les variables** (elles sont listées sous le champ):
   - `{{prenom}}` → Sera remplacé par le prénom du client
   - `{{formation_title}}` → Sera remplacé par le nom de la formation
   - `{{date_debut}}` → Sera remplacé par la date de début
   - Etc.

5. **Cliquez sur Enregistrer**

### 3. Testez l'envoi

1. Cliquez sur le bouton **"Envoyer un test"**
2. Entrez votre email
3. Vérifiez que vous recevez l'email
4. Vérifiez que les variables sont bien remplacées

---

## 🎯 CONFIGURATION DE L'EMAIL ADMINISTRATEUR

**Important:** L'email admin doit être configuré pour recevoir les notifications.

1. Allez dans **Agenda** → **Réglages**
2. Trouvez le champ **"Email administrateur"**
3. Entrez votre email: `admin@votresite.com`
4. Cliquez sur **Enregistrer**

---

## 📋 LES 3 TYPES D'EMAILS

### 1. Email de Confirmation Client

**Quand ?** Dès qu'un client soumet le formulaire de réservation

**À qui ?** Au client (l'email qu'il a saisi)

**Contenu:**
- Confirmation de réception de la demande
- Récapitulatif de la session
- Référence de réservation
- "Nous reviendrons vers vous..."

**Variables utiles:**
```
{{prenom}} {{nom}}
{{formation_title}}
{{session_title}}
{{date_debut}} {{date_fin}}
{{localisation}}
{{booking_key}}
```

---

### 2. Email de Notification Admin

**Quand ?** Dès qu'un client soumet le formulaire

**À qui ?** À vous (l'email admin configuré dans Réglages)

**Contenu:**
- Toutes les infos du client
- Toutes les infos de l'entreprise
- Détails de la demande
- Lien direct vers la réservation dans l'admin

**Variables utiles:**
```
{{prenom}} {{nom}} {{email}} {{telephone}}
{{raison_sociale}} {{siret}}
{{adresse_complete}}
{{nombre_participants}}
{{besoins_specifiques}}
{{commentaires}}
{{admin_url}}
```

---

### 3. Email de Confirmation Inscription

**Quand ?** Quand VOUS confirmez manuellement la réservation dans l'admin

**À qui ?** Au client

**Contenu:**
- Confirmation officielle de l'inscription
- Infos pratiques
- Ce que le client va recevoir prochainement
- Rappel des dates et lieu

**Variables utiles:**
```
{{prenom}} {{nom}}
{{formation_title}}
{{session_title}}
{{date_debut}} {{date_fin}}
{{localisation}}
{{nombre_participants}}
```

---

## 📊 LISTE COMPLÈTE DES VARIABLES

Vous pouvez utiliser ces variables dans les sujets et corps d'emails:

### Informations personnelles
```
{{civilite}}          M., Mme, Autre
{{prenom}}            Prénom du client
{{nom}}               Nom du client
{{email}}             Email du client
{{telephone}}         Téléphone
{{fonction}}          Fonction dans l'entreprise
```

### Informations entreprise
```
{{raison_sociale}}    Nom de l'entreprise
{{siret}}             Numéro SIRET
{{adresse_complete}}  Adresse complète (rue + CP + ville + pays)
{{code_postal}}       Code postal
{{ville}}             Ville
{{pays}}              Pays
{{secteur_activite}}  Secteur d'activité
{{taille_entreprise}} Taille de l'entreprise
```

### Informations formation
```
{{formation_title}}   Nom de la formation
{{session_title}}     Nom de la session
{{date_debut}}        Date de début (format: 15/01/2025)
{{date_fin}}          Date de fin (format: 17/01/2025)
{{duree}}             Durée (ex: "3 jours")
{{localisation}}      Lieu ou "À distance"
```

### Détails réservation
```
{{nombre_participants}}   Nombre de participants
{{besoins_specifiques}}   Besoins spécifiques
{{commentaires}}          Commentaires du client
{{type_facturation}}      Type de prise en charge
{{booking_key}}           Référence unique de réservation
{{created_at}}            Date de la demande
```

### Système
```
{{admin_url}}         Lien vers la réservation (pour emails admin)
{{site_name}}         Nom de votre site
{{site_url}}          URL de votre site
```

---

## ❓ PROBLÈMES COURANTS

### ❌ Les emails ne partent pas

**Causes:**
- WP Mail SMTP pas installé
- WP Mail SMTP mal configuré
- Mauvais identifiants SMTP

**Solutions:**
1. Vérifiez que WP Mail SMTP est activé
2. Allez dans WP Mail SMTP → Email Test
3. Envoyez un test
4. Si ça ne fonctionne pas, vérifiez vos identifiants
5. Essayez avec Gmail (plus simple)

---

### ❌ Les emails vont dans les SPAM

**Causes:**
- Pas de SMTP (utilise PHP mail())
- Email expéditeur invalide

**Solutions:**
1. Utilisez WP Mail SMTP avec un vrai compte email
2. Dans WP Mail SMTP, utilisez un email du MÊME DOMAINE que votre site
   - ✅ Bon: `contact@votresite.com` pour le site `votresite.com`
   - ❌ Mauvais: `contact@gmail.com` pour le site `votresite.com`

---

### ❌ Les variables ne sont pas remplacées

**Causes:**
- Faute de frappe dans la variable
- Espaces dans les accolades

**Solutions:**
1. Vérifiez l'orthographe exacte: `{{prenom}}` pas `{{prénom}}`
2. Pas d'espace: `{{prenom}}` pas `{{ prenom }}`
3. Référez-vous à la liste ci-dessus

---

### ❌ L'admin ne reçoit pas les notifications

**Causes:**
- Email admin pas configuré dans Réglages
- Email admin invalide

**Solutions:**
1. Allez dans **Agenda → Réglages**
2. Vérifiez le champ "Email administrateur"
3. Mettez un email valide
4. Enregistrez

---

## ✅ CHECKLIST FINALE

Avant de considérer que les emails sont configurés:

- [ ] WP Mail SMTP installé et activé
- [ ] WP Mail SMTP configuré (Gmail ou autre)
- [ ] Email de test envoyé et reçu via WP Mail SMTP
- [ ] Email admin configuré dans Agenda → Réglages
- [ ] Template "Confirmation Client" édité et testé
- [ ] Template "Notification Admin" édité et testé
- [ ] Template "Confirmation Inscription" édité et testé
- [ ] Réservation test effectuée
- [ ] Email client reçu après réservation test
- [ ] Email admin reçu après réservation test

---

## 🎉 RÉSUMÉ

**Configuration des emails en 3 étapes:**

1. **WP Mail SMTP**
   - Installez le plugin
   - Configurez avec Gmail (ou autre)
   - Testez l'envoi

2. **Templates**
   - Allez dans Agenda → Templates emails
   - Éditez les 3 templates
   - Utilisez les variables
   - Testez chaque template

3. **Email Admin**
   - Allez dans Agenda → Réglages
   - Configurez l'email administrateur
   - Enregistrez

**Temps total: 10 minutes**

**Une fois configuré, les emails partiront automatiquement à chaque réservation !** 🚀
