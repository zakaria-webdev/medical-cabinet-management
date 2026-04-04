
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

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>>>>>>> dacdc34 (Initial commit: Cabinet Médical - Affichage et Ajout Patients)
