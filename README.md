# 🏥 Système de Gestion de Cabinet Médical

**Application web complète pour la gestion d'un cabinet médical multi-spécialités.**  
Développée avec Laravel 11, elle couvre la prise de rendez-vous, les dossiers patients, les consultations, les ordonnances et le suivi statistique.

[🚀 Démo en ligne](#) · [📖 Documentation](#) · [🐛 Signaler un bug](https://github.com/zakaria-webdev/medical-cabinet-management/issues)

</div>

---

## 📋 Table des Matières

- [Aperçu du Projet](#-aperçu-du-projet)
- [Fonctionnalités](#-fonctionnalités)
- [Stack Technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Base de Données](#-base-de-données)
- [Lancer l'Application](#-lancer-lapplication)
- [Tests](#-tests)
- [Déploiement](#-déploiement)
- [Structure du Projet](#-structure-du-projet)
- [Rôles & Permissions](#-rôles--permissions)
- [Équipe](#-équipe)

---

## 🎯 Aperçu du Projet

Ce projet a été réalisé dans le cadre du module **Programmation Backend PHP** (Semestre S6) à la Faculté des Sciences Semlalia, Université Cadi Ayyad — Marrakech.

Il s'agit d'une application web permettant à un cabinet médical de moderniser et centraliser :
- La gestion des rendez-vous en ligne
- Les dossiers médicaux électroniques des patients
- La rédaction et l'export PDF d'ordonnances
- Le tableau de bord statistique de l'activité du cabinet

---

## ✨ Fonctionnalités

### 🔐 Authentification
- Inscription, connexion et déconnexion sécurisées
- Gestion des rôles et permissions (Admin, Médecin, Secrétaire, Patient)
- Protection CSRF et hashage des mots de passe (bcrypt)

### 👤 Gestion des Patients
- Création et modification de fiches patients
- Recherche avancée par nom, prénom ou CIN
- Consultation de l'historique médical complet

### 📅 Rendez-vous
- Calendrier interactif des disponibilités par médecin
- Prise, modification et annulation de rendez-vous
- Gestion des statuts (Confirmé, En attente, Annulé, Terminé)
- **Notifications email** automatiques (confirmation & rappel de RDV)

### 🩺 Consultation
- Saisie du compte-rendu de consultation
- Génération d'ordonnances médicales
- **Export PDF** des ordonnances (DomPDF)

### 📊 Administration
- Gestion des utilisateurs et du personnel
- Tableau de bord avec **graphiques statistiques** (Chart.js)
- Suivi de l'activité du cabinet en temps réel

### ⚙️ Qualité
- Tests unitaires avec **PHPUnit**
- Seeders pour les données de démonstration

---

## 🛠 Stack Technique

| Composant | Technologie |
|-----------|-------------|
| Backend | Laravel 11.x |
| Frontend | Bootstrap 5 |
| Base de données | MySQL 8.0 |
| ORM | Eloquent |
| PDF | DomPDF (`barryvdh/laravel-dompdf`) |
| Email | Laravel Mail + Mailtrap |
| Graphiques | Chart.js |
| Tests | PHPUnit |
| Versioning | Git / GitHub |
| Hébergement | Railway / Render / VPS |

---

## ✅ Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL** >= 8.0
- **Git**

---

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/zakaria-webdev/medical-cabinet-management.git
cd medical-cabinet-management
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Copier le fichier d'environnement

```bash
cp .env.example .env
```

### 5. Générer la clé d'application

```bash
php artisan key:generate
```

---

## ⚙️ Configuration

Ouvrez le fichier `.env` et configurez les variables suivantes :

### Base de données

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_cabinet
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### Email (Mailtrap pour les tests)

Créez un compte gratuit sur [mailtrap.io](https://mailtrap.io) et récupérez vos identifiants SMTP :

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username_mailtrap
MAIL_PASSWORD=votre_password_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@cabinet-medical.com
MAIL_FROM_NAME="Cabinet Médical"
```

### Application

```env
APP_NAME="Cabinet Médical"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

---

## 🗄️ Base de Données

### 1. Créer la base de données MySQL

```sql
CREATE DATABASE medical_cabinet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Exécuter les migrations

```bash
php artisan migrate
```

### 3. Alimenter avec les données de démonstration

```bash
php artisan db:seed
```

> Cela créera automatiquement des comptes de démonstration pour chaque rôle :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@cabinet.com | password |
| Médecin | medecin@cabinet.com | password |
| Secrétaire | secretaire@cabinet.com | password |
| Patient | patient@cabinet.com | password |

---

## ▶️ Lancer l'Application

### Compiler les assets frontend

```bash
# Développement (avec hot-reload)
npm run dev

# Production
npm run build
```

### Démarrer le serveur de développement

```bash
php artisan serve
```

L'application est accessible sur : **[http://localhost:8000](http://localhost:8000)**

### (Optionnel) Lancer le scheduler pour les rappels email

```bash
php artisan schedule:work
```

---

## 🧪 Tests

### Lancer tous les tests unitaires

```bash
php artisan test
```

### Lancer avec couverture de code

```bash
php artisan test --coverage
```

### Lancer un test spécifique

```bash
php artisan test --filter NomDuTest
```

---

## 🌐 Déploiement

### Déploiement sur Railway

1. Créez un compte sur [railway.app](https://railway.app)
2. Connectez votre dépôt GitHub
3. Ajoutez un service **MySQL** dans Railway
4. Configurez les variables d'environnement (copiez votre `.env.example`)
5. Railway détectera automatiquement le projet Laravel

### Déploiement manuel (VPS / Shared Hosting)

```bash
# Mettre l'application en mode maintenance
php artisan down

# Mettre à jour le code
git pull origin main

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Compiler les assets
npm run build

# Exécuter les migrations
php artisan migrate --force

# Vider et reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Remettre l'application en ligne
php artisan up
```

---

## 📁 Structure du Projet

```
medical-cabinet-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Contrôleurs MVC
│   │   │   ├── AuthController.php
│   │   │   ├── PatientController.php
│   │   │   ├── RendezVousController.php
│   │   │   ├── ConsultationController.php
│   │   │   └── AdminController.php
│   │   └── Middleware/           # Middlewares (rôles, auth)
│   ├── Models/                   # Modèles Eloquent
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── Medecin.php
│   │   ├── RendezVous.php
│   │   ├── Consultation.php
│   │   └── Ordonnance.php
│   ├── Mail/                     # Classes email
│   └── Notifications/
├── database/
│   ├── migrations/               # Migrations de la BDD
│   └── seeders/                  # Données de démonstration
├── resources/
│   ├── views/                    # Vues Blade
│   │   ├── auth/
│   │   ├── patients/
│   │   ├── rendezvous/
│   │   ├── consultations/
│   │   └── admin/
│   └── pdf/                      # Templates PDF ordonnances
├── routes/
│   └── web.php                   # Définition des routes
├── tests/
│   └── Unit/                     # Tests PHPUnit
└── public/
    └── assets/                   # CSS, JS compilés
```

---

## 👥 Rôles & Permissions

| Fonctionnalité | Admin | Médecin | Secrétaire | Patient |
|----------------|:-----:|:-------:|:----------:|:-------:|
| Gestion utilisateurs | ✅ | ❌ | ❌ | ❌ |
| Tableau de bord stats | ✅ | ✅ | ❌ | ❌ |
| Gestion patients | ✅ | ✅ | ✅ | ❌ |
| Prise de rendez-vous | ✅ | ❌ | ✅ | ✅ |
| Consultation & ordonnances | ❌ | ✅ | ❌ | ❌ |
| Voir ses RDV | ❌ | ✅ | ❌ | ✅ |
| Export PDF ordonnance | ❌ | ✅ | ❌ | ✅ |

---

## 👨‍💻 Équipe

Projet réalisé dans le cadre du **Module Programmation Backend PHP — S6**  
Encadré par **Mme JABIR Somaya** & **Mme BABA Naima**  
Faculté des Sciences Semlalia — Université Cadi Ayyad, Marrakech  
Année universitaire : **2025/2026**

---



**⭐ Si ce projet vous a été utile, n'hésitez pas à lui mettre une étoile sur GitHub !**


