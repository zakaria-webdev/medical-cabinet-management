{{-- [Houcine] Vue Blade de l'email de confirmation RDV - Sprint 2 --}}
{{-- Cette vue est appelée par RendezVousConfirme::content() --}}
{{-- Elle reçoit automatiquement $rendezVous car c'est une propriété --}}
{{-- publique du Mailable (public RendezVous $rendezVous) --}}
{{-- Style inline obligatoire pour les emails : la majorité des clients --}}
{{-- mail (Gmail, Outlook) ignorent les CSS externes et les <style> --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation RDV</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">

    {{-- Conteneur principal centré --}}
    <table width="100%" cellpadding="0" cellspacing="0"
           style="background-color:#f4f6f8; padding: 40px 0;">
        <tr>
            <td align="center">

                {{-- Carte email --}}
                <table width="600" cellpadding="0" cellspacing="0"
                       style="background-color:#ffffff; border-radius:8px;
                              box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow:hidden;">

                    {{-- Header bleu --}}
                    <tr>
                        <td style="background-color:#0d6efd; padding: 30px 40px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:22px; font-weight:bold;">
                                🏥 Cabinet Médical
                            </h1>
                            <p style="margin:8px 0 0; color:#cfe2ff; font-size:14px;">
                                Confirmation de Rendez-Vous
                            </p>
                        </td>
                    </tr>

                    {{-- Corps de l'email --}}
                    <tr>
                        <td style="padding: 40px;">

                            {{-- Salutation --}}
                            <p style="margin:0 0 20px; font-size:16px; color:#333333;">
                                Bonjour,
                            </p>
                            <p style="margin:0 0 30px; font-size:15px; color:#555555; line-height:1.6;">
                                Votre rendez-vous a été enregistré avec succès.
                                Voici le récapitulatif :
                            </p>

                            {{-- Bloc récapitulatif RDV --}}
                            {{-- $rendezVous est accessible car propriété publique du Mailable --}}
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="background-color:#f0f4ff; border-radius:6px;
                                          border-left: 4px solid #0d6efd; margin-bottom:30px;">
                                <tr>
                                    <td style="padding: 20px 24px;">

                                        {{-- Patient --}}
                                        <p style="margin:0 0 12px; font-size:14px; color:#666;">
                                            <strong style="color:#333;">👤 Patient :</strong>
                                            {{ $rendezVous->patient->prenom }}
                                            {{ $rendezVous->patient->nom }}
                                        </p>

                                        {{-- Médecin --}}
                                        <p style="margin:0 0 12px; font-size:14px; color:#666;">
                                            <strong style="color:#333;">🩺 Médecin :</strong>
                                            Dr. {{ $rendezVous->medecin->prenom }}
                                            {{ $rendezVous->medecin->nom }}
                                        </p>

                                        {{-- Date - format('d/m/Y') fonctionne car --}}
                                        {{-- date_rdv est casté en Carbon dans RendezVous.php --}}
                                        <p style="margin:0 0 12px; font-size:14px; color:#666;">
                                            <strong style="color:#333;">📅 Date :</strong>
                                            {{ $rendezVous->date_rdv->format('d/m/Y') }}
                                        </p>

                                        {{-- Heure --}}
                                        <p style="margin:0 0 12px; font-size:14px; color:#666;">
                                            <strong style="color:#333;">🕐 Heure :</strong>
                                            {{ $rendezVous->heure_rdv }}
                                        </p>

                                        {{-- Motif affiché uniquement s'il existe (nullable) --}}
                                        @if($rendezVous->motif)
                                        <p style="margin:0; font-size:14px; color:#666;">
                                            <strong style="color:#333;">📋 Motif :</strong>
                                            {{ $rendezVous->motif }}
                                        </p>
                                        @endif

                                    </td>
                                </tr>
                            </table>

                            {{-- Message de rappel --}}
                            <p style="margin:0 0 30px; font-size:14px; color:#888888;
                                      line-height:1.6; border-top:1px solid #eeeeee;
                                      padding-top:20px;">
                                ⚠️ Si vous souhaitez annuler ou modifier ce rendez-vous,
                                veuillez contacter le cabinet au plus tôt.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#f8f9fa; padding: 20px 40px;
                                   text-align:center; border-top:1px solid #eeeeee;">
                            <p style="margin:0; font-size:12px; color:#aaaaaa;">
                                Cabinet Médical — Système de Gestion Automatisé
                            </p>
                            <p style="margin:4px 0 0; font-size:12px; color:#aaaaaa;">
                                Cet email a été envoyé automatiquement, merci de ne pas répondre.
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- fin carte email --}}

            </td>
        </tr>
    </table>

</body>
</html>