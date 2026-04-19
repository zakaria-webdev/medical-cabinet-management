<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-dark: #0f2c4c;
            --primary-light: #00a8e8;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: var(--primary-dark);
        }
        .hero-section {
            background: linear-gradient(135deg, var(--primary-light) 0%, #007bb5 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .feature-icon {
            font-size: 40px;
            color: var(--primary-light);
            margin-bottom: 15px;
        }
        .footer {
            background-color: var(--primary-dark);
            color: white;
            padding: 50px 0 20px;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-stethoscope"></i> Cabinet Médical
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Nos Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Se connecter</a>
                    <a href="{{ route('register') }}" class="btn btn-info text-white fw-bold">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Bienvenue sur votre portail médical</h1>
            <p class="lead mb-5">Prenez vos rendez-vous médicaux en ligne facilement, rapidement et gratuitement 7j/7 - 24h/24.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg text-primary fw-bold px-5 rounded-pill shadow">
                    <i class="far fa-calendar-alt"></i> Prendre un rendez-vous
                </a>
            </div>
        </div>
    </section>

    <section id="services" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5" style="color: var(--primary-dark);">Comment ça marche ?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <i class="fas fa-search feature-icon"></i>
                        <h4 class="fw-bold">1. Cherchez</h4>
                        <p class="text-muted">Trouvez le créneau qui vous convient selon vos disponibilités.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <i class="fas fa-calendar-check feature-icon"></i>
                        <h4 class="fw-bold">2. Prenez Rendez-vous</h4>
                        <p class="text-muted">Réservez votre consultation en quelques clics via votre espace patient.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <i class="fas fa-user-md feature-icon"></i>
                        <h4 class="fw-bold">3. Consultez</h4>
                        <p class="text-muted">Bénéficiez d'un suivi médical de qualité et accédez à votre dossier.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="footer">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-white mb-3"><i class="fas fa-stethoscope"></i> Cabinet Médical</h5>
                    <p class="text-light" style="opacity: 0.8">La plateforme médicale en ligne qui facilite la communication entre les patients et les professionnels de santé.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-white mb-3">CONTACTEZ NOUS</h5>
                    <ul class="list-unstyled text-light" style="opacity: 0.8;">
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +212 6 00 00 00 00</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> contact@cabinet-medical.ma</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Marrakech, Maroc</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-white mb-3">LIENS RAPIDES</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('login') }}">Espace Patient</a></li>
                        <li><a href="{{ route('login') }}">Espace Médecin</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center border-top border-secondary pt-3 mt-3">
                <p class="mb-0 text-light" style="opacity: 0.8;">&copy; 2026 Cabinet Médical. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
