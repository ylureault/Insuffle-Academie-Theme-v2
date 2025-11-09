# Guide CTA Formations Paramétrable

## 🎯 Vue d'ensemble

Votre thème dispose maintenant d'un **Call-to-Action (CTA) unique et paramétrable** qui s'affiche automatiquement en bas de **toutes vos pages de formations**.

**Avantages :**
- ✅ Un seul endroit pour modifier le CTA de toutes les formations
- ✅ Pas besoin de toucher au code
- ✅ Aperçu en direct de vos modifications
- ✅ Cohérence garantie sur toutes les formations
- ✅ Design magnifique avec animations

---

## 🚀 Configuration Rapide

### Étape 1 : Accéder aux réglages

1. Connectez-vous à l'administration WordPress
2. Allez dans **Apparence > Personnaliser**
3. Cliquez sur **CTA Formations**

### Étape 2 : Configurer les textes

Dans la section "CTA Formations", vous pouvez personnaliser :

#### 📝 Titre
**Champ** : Titre du CTA
**Exemple** : "Prêt à transformer votre pratique professionnelle ?"

#### 📝 Sous-titre
**Champ** : Sous-titre / Description
**Exemple** : "Contactez notre équipe pour en savoir plus sur nos formations et obtenir un devis personnalisé"

#### 📝 Bouton Principal (Jaune)
**Champ** : Bouton 1 - Texte
**Exemple** : "Demander un devis"

**Champ** : Bouton 1 - Lien
**Exemple** : `/#contact` ou `/contact/`

#### 📝 Bouton Secondaire (Bordure blanche)
**Case à cocher** : Afficher le bouton 2
**Champ** : Bouton 2 - Texte
**Exemple** : "Nous appeler"

**Champ** : Bouton 2 - Lien
**Exemples** :
- Téléphone : `tel:+33980808962`
- Email : `mailto:contact@insuffle-academie.com`
- Page : `/contact/`

#### 📝 Informations complémentaires
**Champ** : Informations complémentaires
**Exemple** : "✅ Certification Qualiopi • 💰 Financement OPCO • 📞 Réponse sous 24h"

### Étape 3 : Choisir le style

**Champ** : Style du CTA
**Options** :
- **Violet** (par défaut) - Fond violet avec dégradé
- **Dégradé** - Dégradé violet-rose-accent
- **Blanc** - Fond blanc/gris clair

### Étape 4 : Publier

Cliquez sur **Publier** en haut du Customizer pour sauvegarder vos modifications.

---

## 🎨 Aperçu en Direct

Pendant que vous modifiez les textes dans le Customizer :
- Le **titre** se met à jour en direct
- Le **sous-titre** se met à jour en direct
- Les **textes des boutons** se mettent à jour en direct
- Les **informations** se mettent à jour en direct

**Note** : Pour voir les changements de liens et de style, vous devez rafraîchir la page.

---

## 📍 Où le CTA s'affiche-t-il ?

Le CTA s'affiche **automatiquement** sur :

### ✅ Pages de formations
- Toutes les pages enfants de "Formations"
- Toutes les pages dont le slug contient "formation"
- Toutes les pages utilisant le template "Formation Gamifiée"

### ❌ Pages exclues
- Page parente "Formations" (liste des formations)
- Pages légales (mentions légales, CGV, etc.)
- Page contact
- Autres pages du site

---

## 💡 Exemples de Configuration

### Configuration Standard
```
Titre : "Prêt à vous former ?"
Sous-titre : "Contactez-nous pour obtenir un devis personnalisé"
Bouton 1 : "Demander un devis" → /#contact
Bouton 2 : "Nous appeler" → tel:+33980808962
Info : "✅ Certification Qualiopi • 💰 Financement OPCO"
Style : Violet
```

### Configuration Minimaliste
```
Titre : "Une question sur cette formation ?"
Sous-titre : "Notre équipe est là pour vous accompagner"
Bouton 1 : "Nous contacter" → /contact/
Bouton 2 : [DÉSACTIVÉ]
Info : "📞 Réponse sous 24h"
Style : Blanc
```

### Configuration Dynamique
```
Titre : "🎯 Passez à l'action !"
Sous-titre : "Transformez votre organisation dès aujourd'hui"
Bouton 1 : "Planifier un RDV" → https://calendly.com/votre-lien
Bouton 2 : "Télécharger le programme" → /programmes/formation.pdf
Info : "💰 Prise en charge OPCO possible • ⚡ Début sous 30 jours"
Style : Dégradé
```

---

## 🎨 Styles Disponibles

### 1️⃣ Violet (par défaut)
- Fond : Dégradé violet (#8E2183 → #6b1960)
- Texte : Blanc
- Bouton primaire : Jaune (#FFD466)
- Bouton secondaire : Bordure blanche
- Effets : Cercles animés jaunes et roses

**Quand l'utiliser** : Pour 90% de vos formations. C'est le style le plus impactant.

### 2️⃣ Dégradé
- Fond : Dégradé violet-rose-accent
- Texte : Blanc
- Bouton primaire : Jaune
- Bouton secondaire : Bordure blanche
- Effets : Cercles animés

**Quand l'utiliser** : Pour des formations premium ou événements spéciaux.

### 3️⃣ Blanc
- Fond : Gris clair (#f8f9fa)
- Texte : Violet/Noir
- Bouton primaire : Jaune
- Bouton secondaire : Bordure violette
- Effets : Aucun (plus sobre)

**Quand l'utiliser** : Pour un look plus professionnel ou corporate.

---

## ⚙️ Options Avancées

### Désactiver complètement le CTA

Si vous voulez retirer le CTA temporairement :
1. Dans **Apparence > Personnaliser > CTA Formations**
2. Décochez **"Afficher le CTA sur les formations"**
3. Publier

### Masquer le bouton secondaire

Si vous ne voulez qu'un seul bouton :
1. Décochez **"Afficher le bouton 2"**

### Personnaliser avec des emojis

Vous pouvez ajouter des emojis dans tous les champs texte :
- Titre : `🎯 Prêt à vous former ?`
- Info : `✅ Qualiopi • 💰 OPCO • 📞 24h`

---

## 🔧 Personnalisation CSS Avancée

Si vous voulez personnaliser davantage le design, ajoutez du CSS personnalisé dans **Apparence > Personnaliser > CSS additionnel**.

### Exemples :

#### Changer la couleur du bouton primaire
```css
.formation-cta-btn-primary {
    background: #FF6B6B !important; /* Rouge */
}
```

#### Modifier la taille du titre
```css
.formation-cta-title {
    font-size: 3.5rem !important;
}
```

#### Ajouter une ombre au container
```css
.formation-cta {
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
```

---

## 📱 Responsive

Le CTA est **100% responsive** et s'adapte automatiquement :

### Desktop (>768px)
- 2 boutons côte à côte
- Titre 2.8rem
- Largeur max 900px

### Mobile (<768px)
- Boutons empilés verticalement
- Titre 2rem
- Boutons full width (max 300px)
- Padding réduit

---

## 🆘 Dépannage

### Le CTA ne s'affiche pas

**Vérifiez** :
1. Que l'option "Afficher le CTA sur les formations" est cochée
2. Que vous êtes bien sur une page de formation
3. Que la page n'a pas de métadonnée `_hide_cta` activée

### Les modifications ne s'affichent pas

**Solutions** :
1. Videz le cache WordPress (si plugin de cache actif)
2. Videz le cache du navigateur (Ctrl+F5)
3. Vérifiez que vous avez bien cliqué sur "Publier"

### L'aperçu en direct ne fonctionne pas

**C'est normal pour** :
- Les changements de liens (URL des boutons)
- Les changements de style de fond
- L'activation/désactivation

→ Rafraîchissez la page pour voir ces changements.

---

## 🎯 Bonnes Pratiques

### ✅ À FAIRE

- Garder un titre court et percutant (max 60 caractères)
- Utiliser un verbe d'action dans les boutons ("Demander", "Obtenir", "Découvrir")
- Mettre le lien le plus important dans le bouton primaire (jaune)
- Utiliser des emojis pour attirer l'œil
- Tester sur mobile après chaque modification

### ❌ À ÉVITER

- Texte trop long (le sous-titre ne doit pas dépasser 2 lignes)
- Trop d'emojis (1-2 max dans le titre)
- Liens cassés (toujours vérifier que les liens fonctionnent)
- Modifier trop souvent (gardez une cohérence)

---

## 📊 Analytics

Pour suivre les clics sur vos boutons CTA :

### Avec Google Analytics

Ajoutez des paramètres UTM à vos liens :
```
/#contact?utm_source=formation&utm_medium=cta&utm_campaign=devis
```

### Avec un plugin WordPress

Utilisez un plugin comme "Pretty Links" ou "MonsterInsights" pour tracker les clics.

---

## 🔄 Mises à jour

Le CTA est géré par le thème. Lors des mises à jour du thème :
- Vos paramètres sont **conservés**
- Le design peut être amélioré
- De nouvelles options peuvent être ajoutées

---

## 📞 Support

Besoin d'aide pour configurer votre CTA ?
- Email : support@insuffle-academie.com
- Documentation complète : Voir GUIDE-CONFIGURATION.md

---

**Version** : 3.3
**Dernière mise à jour** : 2025
**Compatibilité** : WordPress 6.0+
