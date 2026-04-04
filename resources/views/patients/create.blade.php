<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Patient - Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white py-3">
                        <h4 class="mb-0">Ajouter un Nouveau Patient</h4>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('patients.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nom</label>
                                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Nom du patient" required>
                                    @error('nom') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Prénom</label>
                                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Prénom du patient" required>
                                    @error('prenom') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">CIN</label>
                                    <input type="text" name="cin" class="form-control @error('cin') is-invalid @enderror" value="{{ old('cin') }}" placeholder="Ex: AB123456">
                                    @error('cin') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" placeholder="06XXXXXXXX" required>
                                    @error('telephone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Date de Naissance</label>
                                    <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Sexe</label>
                                    <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                                        <option value="">Choisir...</option>
                                        <option value="Homme" {{ old('sexe') == 'Homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="Femme" {{ old('sexe') == 'Femme' ? 'selected' : '' }}>Femme</option>
                                    </select>
                                    @error('sexe') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Adresse</label>
                                <textarea name="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="3" placeholder="Adresse complète">{{ old('adresse') }}</textarea>
                                @error('adresse') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-success px-4">Enregistrer le Patient</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
