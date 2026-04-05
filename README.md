
# medical-cabinet-management
Système de gestion de cabinet médical conçu pour simplifier le suivi des patients et la prise de rendez-vous.

## 📖 À propos du projet

Ce projet est un **Système de Gestion de Cabinet Médical** complet, développé pour simplifier et automatiser les tâches administratives et médicales quotidiennes d'un cabinet médical. 

L'objectif principal de cette application est de fournir une solution numérique qui remplace les méthodes traditionnelles sur papier, garantissant ainsi une meilleure organisation, un accès plus rapide aux informations et une expérience améliorée tant pour le personnel médical que pour les patients.

### ✨ Fonctionnalités Principales
* **Gestion des patients :** Ajouter, mettre à jour et gérer les profils des patients et leurs informations personnelles.
* **Prise de rendez-vous :** Planifier, modifier ou annuler facilement les rendez-vous des patients.
* **Dossiers Médicaux :** Assurer le suivi des antécédents médicaux, des consultations et des prescriptions.

🏗️ Architecture MVC & Répartition des Fichiers
Afin d'éviter les conflits sur Git et de travailler efficacement en équipe, nous avons organisé notre code en nous basant sur l'architecture MVC (Model-View-Controller) avec une approche par fonctionnalité.

Bien que nous travaillions tous sur le même projet Laravel, chacun sera responsable de ses propres fichiers (Modèles, Vues et Contrôleurs) sans interférer avec le code des autres. Le seul fichier commun que nous serons amenés à modifier ensemble est le fichier des routes (routes/web.php).

Voici la structure exacte des dossiers pour que chacun sache exactement où créer et placer son code :

📂 cabinet-medical (Projet Laravel)
│
├── 📂 app
│   ├── 📂 Http
│   │   ├── 📂 Controllers (C)
│   │   │   ├── AuthController.php             <-- 👨‍💻 Personne 1 (Auth & Sécurité)
│   │   │   ├── PatientController.php          <-- 👨‍💻 Personne 2 (CRUD Patients)
│   │   │   └── DossierMedicalController.php   <-- 👨‍💻 Personne 3 (Historique)
│   │   │
│   │   └── 📂 Middleware
│   │       └── CheckRole.php                  <-- 👨‍💻 Personne 3 (Gestion des Rôles)
│   │
│   └── 📂 Models (M)
│       ├── User.php                           <-- 👨‍💻 Personne 1 
│       ├── Patient.php                        <-- 👨‍💻 Personne 2
│       └── DossierMedical.php                 <-- 👨‍💻 Personne 3
│
├── 📂 database
│   └── 📂 migrations
│       ├── ..._create_users_table.php             <-- 👨‍💻 Personne 1
│       ├── ..._create_patients_table.php          <-- 👨‍💻 Personne 2
│       └── ..._create_dossiers_medicaux_table.php <-- 👨‍💻 Personne 3
│
├── 📂 resources
│   └── 📂 views (V)
│       ├── 📂 auth                            <-- 👨‍💻 Personne 1
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       │
│       ├── 📂 patients                        <-- 👨‍💻 Personne 2
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       │
│       └── 📂 dossiers                        <-- 👨‍💻 Personne 3
│           └── show.blade.php
│
└── 📂 routes
    └── web.php                                <-- 🤝 TOUT LE MONDE (هنا غتجمعو الروابط كاملين)

