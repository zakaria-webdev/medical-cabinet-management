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
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nom :</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $patient->nom) }}" required>
                            @error('nom') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Prénom :</label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $patient->prenom) }}" required>
                            @error('prenom') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">CIN :</label>
                            <input type="text" name="cin" class="form-control @error('cin') is-invalid @enderror" value="{{ old('cin', $patient->cin) }}">
                            @error('cin') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Téléphone :</label>
                            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $patient->telephone) }}" required>
                            @error('telephone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sexe :</label>
                            <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                                <option value="Homme" {{ old('sexe', $patient->sexe) == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('sexe', $patient->sexe) == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('sexe') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date de Naissance :</label>
                            <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance', $patient->date_naissance) }}" required>
                            @error('date_naissance') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Adresse :</label>
                        <textarea name="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="3">{{ old('adresse', $patient->adresse) }}</textarea>
                        @error('adresse') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
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
