<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-info text-white py-3">
                <h3 class="mb-0">👁️ Dossier du Patient : {{ $patient->nom }} {{ $patient->prenom }}</h3>
            </div>

            <div class="card-body fs-5">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>ID :</strong> <span class="text-muted">#{{ $patient->id }}</span></p>
                        <p><strong>CIN :</strong> <span class="badge bg-secondary text-uppercase">{{ $patient->cin }}</span></p>
                        <p><strong>Téléphone :</strong> {{ $patient->telephone }}</p>
                        <p><strong>Sexe :</strong> {{ $patient->sexe }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Date de Naissance :</strong> {{ $patient->date_naissance }}</p>
                        <p><strong>Adresse :</strong> {{ $patient->adresse ? $patient->adresse : 'Non spécifiée' }}</p>
                        <p><strong>Date d'inscription :</strong> {{ $patient->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="d-flex gap-2 border-top pt-3">
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                        ⬅️ Retour à la liste
                    </a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">
                        ✏️ Modifier les informations
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
