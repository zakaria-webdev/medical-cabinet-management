<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-dark py-3">
                <h3 class="mb-0">✏️ Modifier les informations : {{ $patient->nom }} {{ $patient->prenom }}</h3>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- هاد السطر ضروري فـ التعديل -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nom :</label>
                            <input type="text" name="nom" class="form-control" value="{{ $patient->nom }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Prénom :</label>
                            <input type="text" name="prenom" class="form-control" value="{{ $patient->prenom }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">CIN :</label>
                            <input type="text" name="cin" class="form-control" value="{{ $patient->cin }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Téléphone :</label>
                            <input type="text" name="telephone" class="form-control" value="{{ $patient->telephone }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sexe :</label>
                            <select name="sexe" class="form-select" required>
                                <option value="Homme" {{ $patient->sexe == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ $patient->sexe == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date de Naissance :</label>
                            <input type="date" name="date_naissance" class="form-control" value="{{ $patient->date_naissance }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Adresse :</label>
                        <textarea name="adresse" class="form-control" rows="3">{{ $patient->adresse }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">✅ Enregistrer les modifications</button>
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
