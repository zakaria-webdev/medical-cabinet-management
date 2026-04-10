<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordonnance</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #2c3e50; padding-bottom: 10px; margin-bottom: 20px; }
        .medecin-info { font-size: 18px; font-weight: bold; color: #2c3e50; }
        .date { text-align: right; margin-bottom: 30px; font-style: italic; }
        .patient-info { font-size: 16px; margin-bottom: 40px; }
        .ordonnance-title { text-align: center; font-size: 22px; font-weight: bold; text-decoration: underline; margin-bottom: 30px; }
        .medicaments { margin-bottom: 40px; white-space: pre-line; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; }
        .footer { position: absolute; bottom: 30px; width: 100%; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
        .signature { text-align: right; margin-top: 50px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <div class="medecin-info">Cabinet Médical</div>
        <div>Dr. {{ $consultation->medecin->nom ?? '_________' }} {{ $consultation->medecin->prenom ?? '' }}</div>
        <div>Médecine Générale</div>
    </div>

    <div class="date">
        Fait à Marrakech, le : {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}
    </div>

    <div class="patient-info">
        <strong>Patient(e) :</strong> {{ $consultation->dossierMedical->patient->nom ?? 'Inconnu' }} {{ $consultation->dossierMedical->patient->prenom ?? '' }}
    </div>

    <div class="ordonnance-title">ORDONNANCE</div>

    <div class="medicaments">
        {{ $consultation->ordonnance->medicaments_details }}
    </div>

    @if($consultation->ordonnance->notes_utilisation)
    <div>
        <strong>Notes :</strong> <br>
        {{ $consultation->ordonnance->notes_utilisation }}
    </div>
    @endif

    <div class="signature">
        Signature et Cachet :
    </div>

    <div class="footer">
        Ceci est une ordonnance générée électroniquement par le système de gestion de cabinet.
    </div>

</body>
</html>
