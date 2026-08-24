# In Memoriam - Extension Forum PHP

Version 1.6.0

Extension multilingue complète pour gérer les comptes d'utilisateurs décédés avec système de succession sécurisé.

## 📋 Fonctionnalités

### 1. Bandeau Commémoratif
- Affichage d'un bandeau noir personnalisable sur les profils des utilisateurs décédés
- Texte mémoriel personnalisable
- Date de décès optionnelle
- Couleur du bandeau modifiable
- Badge sur les posts de l'utilisateur

### 2. Système de Légataire
- Désignation d'une personne de confiance
- Double code de sécurité (utilisateur + admin)
- Envoi automatique d'email avec PDF
- QR Code pour validation rapide
- Traçabilité complète des actions

### 3. Sécurité Renforcée
- Code de sécurité unique de 64 caractères
- QR Code avec token unique
- Clé de validation administrateur
- Double validation (légataire + admin)
- Logs détaillés de toutes les actions

### 4. Interface Admin Complète
- Gestion des utilisateurs décédés
- Validation des demandes de succession
- Historique des actions
- Interface moderne et responsive

### 5. Multilingue
- Français (FR)
- Anglais (EN)
- Facilement extensible

## 🚀 Installation

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Extension PHP GD (pour les QR codes)
- Extension PHP Mail configurée

### Étapes d'installation

1. **Télécharger l'extension**
   ```bash
   git clone https://github.com/votre-repo/in-memoriam.git
   ```

2. **Copier les fichiers**
   ```bash
   cp -r in_memoriam/ /chemin/vers/votre/forum/extensions/
   ```

3. **Créer les dossiers nécessaires**
   ```bash
   mkdir -p in_memoriam/qrcodes
   mkdir -p in_memoriam/pdfs
   chmod 755 in_memoriam/qrcodes
   chmod 755 in_memoriam/pdfs
   ```

4. **Installer les dépendances**
   
   Télécharger phpqrcode :
   ```bash
   wget https://sourceforge.net/projects/phpqrcode/files/latest/download
   unzip download -d in_memoriam/lib/
   ```
   
   Télécharger FPDF :
   ```bash
   wget http://www.fpdf.org/en/download/fpdf184.zip
   unzip fpdf184.zip -d in_memoriam/lib/
   ```

5. **Activer l'extension**
   
   Dans votre fichier principal du forum, ajoutez :
   ```php
   require_once 'extensions/in_memoriam/index.php';
   ```

6. **Créer les tables**
   
   Les tables seront créées automatiquement lors du premier chargement.
   Vous pouvez aussi exécuter manuellement :
   ```php
   InMemoriam_Database::install();
   ```

## 📖 Utilisation

### Pour les utilisateurs

#### Désigner un légataire

1. Accéder aux paramètres In Memoriam :
   ```
   ?memoriam_action=user_settings
   ```

2. Remplir le formulaire :
   - Nom complet du légataire
   - Email du légataire
   - Cliquer sur "Enregistrer"

3. Conserver la clé de validation administrateur affichée

#### Pour le légataire

1. Accéder à la page de demande :
   ```
   ?memoriam_action=legacy_request
   ```

2. Entrer l'ID de l'utilisateur décédé

3. Recevoir l'email avec :
   - Code de sécurité
   - PDF avec QR code
   - Lien de validation

4. Scanner le QR code ou cliquer sur le lien

5. Entrer le code de sécurité

6. Attendre la validation admin

### Pour les administrateurs

#### Marquer un utilisateur comme décédé

1. Accéder à l'interface admin :
   ```
   ?memoriam_action=admin
   ```

2. Cliquer sur "Marquer comme décédé"

3. Remplir le formulaire :
   - ID de l'utilisateur
   - Date de décès (optionnel)
   - Texte mémoriel (optionnel)
   - Couleur du bandeau

4. Enregistrer

#### Valider une demande de suppression

1. Aller dans l'onglet "Demandes de succession"

2. Trouver la demande validée par le légataire

3. Cliquer sur "Valider la demande"

4. Vérifier la clé de validation sur le profil de l'utilisateur

5. Confirmer la suppression

## 🗂️ Structure des fichiers

```
in_memoriam/
├── index.php                    # Point d'entrée principal
├── includes/
│   ├── database.php            # Gestion base de données
│   ├── functions.php           # Fonctions principales
│   └── language.php            # Système multilingue
├── admin/
│   └── index.php               # Interface admin
├── user/
│   └── settings.php            # Paramètres utilisateur
├── legacy/
│   ├── request.php             # Demande de suppression
│   └── validate.php            # Validation du code
├── assets/
│   └── css/
│       └── style.css           # Styles CSS
├── lib/
│   ├── phpqrcode/              # Bibliothèque QR Code
│   └── fpdf/                   # Bibliothèque PDF
├── qrcodes/                    # QR codes générés
├── pdfs/                       # PDFs générés
└── README.md                   # Documentation
```

## 🗄️ Structure de la base de données

### Table : in_memoriam_deceased
Stocke les informations sur les utilisateurs décédés.

| Champ          | Type        | Description                    |
|----------------|-------------|--------------------------------|
| id             | INT(11)     | Identifiant unique             |
| user_id        | INT(11)     | ID de l'utilisateur            |
| death_date     | DATE        | Date de décès                  |
| marked_by      | INT(11)     | ID de l'admin                  |
| marked_date    | DATETIME    | Date de marquage               |
| memorial_text  | TEXT        | Texte mémoriel                 |
| banner_color   | VARCHAR(7)  | Couleur du bandeau             |
| status         | ENUM        | Statut (active/removed)        |

### Table : in_memoriam_legacy
Stocke les informations sur les légataires.

| Champ                  | Type         | Description                    |
|------------------------|--------------|--------------------------------|
| id                     | INT(11)      | Identifiant unique             |
| user_id                | INT(11)      | ID de l'utilisateur            |
| legacy_name            | VARCHAR(255) | Nom du légataire               |
| legacy_email           | VARCHAR(255) | Email du légataire             |
| security_code          | VARCHAR(64)  | Code de sécurité               |
| qr_code_token          | VARCHAR(64)  | Token du QR code               |
| admin_validation_key   | VARCHAR(64)  | Clé de validation admin        |
| status                 | ENUM         | Statut de la demande           |
| request_date           | DATETIME     | Date de la demande             |
| validation_date        | DATETIME     | Date de validation             |
| admin_validation_date  | DATETIME     | Date de validation admin       |

### Table : in_memoriam_logs
Stocke les logs de toutes les actions.

| Champ        | Type         | Description                    |
|--------------|--------------|--------------------------------|
| id           | INT(11)      | Identifiant unique             |
| user_id      | INT(11)      | ID de l'utilisateur            |
| action       | VARCHAR(100) | Action effectuée               |
| performed_by | INT(11)      | ID de l'auteur                 |
| ip_address   | VARCHAR(45)  | Adresse IP                     |
| user_agent   | VARCHAR(255) | User agent                     |
| details      | TEXT         | Détails supplémentaires        |
| created_at   | TIMESTAMP    | Date de création               |

## 🔒 Sécurité

### Mesures de sécurité implémentées

1. **Double validation**
   - Code de sécurité unique pour le légataire
   - Clé de validation pour l'administrateur

2. **Tokens uniques**
   - Génération de codes aléatoires cryptographiquement sûrs
   - 64 caractères pour le code de sécurité
   - 32 caractères pour les tokens

3. **Traçabilité**
   - Logs de toutes les actions
   - Enregistrement des IP et user agents
   - Horodatage de chaque étape

4. **Sanitization**
   - Nettoyage de toutes les entrées utilisateur
   - Protection contre les injections SQL
   - Échappement des sorties HTML

5. **Protection des données**
   - Emails chiffrés (selon config serveur)
   - Stockage sécurisé des codes
   - Suppression automatique après validation

## 🌍 Ajouter une langue

Pour ajouter une nouvelle langue :

1. Ouvrir `includes/language.php`

2. Ajouter un nouveau tableau dans `$languages` :
   ```php
   'es' => array(
       'in_memoriam' => 'In Memoriam',
       'default_memorial_text' => 'En memoria de...',
       // ... autres traductions
   )
   ```

3. La langue sera automatiquement disponible

## 🎨 Personnalisation

### Modifier les couleurs du bandeau

Dans `assets/css/style.css`, modifier :
```css
.in-memoriam-banner {
    background: linear-gradient(135deg, #2c3e50 0%, #000000 100%);
}
```

### Changer le texte par défaut

Dans `includes/language.php`, modifier :
```php
'default_memorial_text' => 'Votre texte personnalisé'
```

### Modifier le format d'email

Dans `includes/functions.php`, fonction `in_memoriam_send_legacy_email()`.

## 🐛 Dépannage

### Les tables ne se créent pas
```php
// Exécuter manuellement
require_once 'extensions/in_memoriam/includes/database.php';
InMemoriam_Database::install();
```

### Les emails ne sont pas envoyés
- Vérifier la configuration SMTP du serveur
- Vérifier les logs PHP
- Tester avec `mail()` basique

### Les QR codes ne se génèrent pas
- Vérifier que GD est installé : `php -m | grep gd`
- Vérifier les permissions du dossier `qrcodes/`
- Installer phpqrcode correctement

### Les PDFs sont vides
- Vérifier que FPDF est installé
- Vérifier les permissions du dossier `pdfs/`
- Vérifier les logs d'erreurs PHP

## 📝 Licence

Cette extension est fournie sous licence MIT.

## 👥 Support

Pour toute question ou problème :
- Créer une issue sur GitHub
- Email : support@votre-domaine.com

## 🔄 Mises à jour

### Version 1.0.0 (Actuelle)
- Première version stable
- Toutes les fonctionnalités de base
- Support FR et EN

## 🙏 Remerciements

- FPDF pour la génération de PDF
- phpqrcode pour les QR codes
- La communauté PHP pour les retours

---

**Note importante** : Cette extension traite des sujets sensibles. Assurez-vous d'avoir les autorisations nécessaires et de respecter les lois sur la protection des données (RGPD, etc.) dans votre juridiction.
