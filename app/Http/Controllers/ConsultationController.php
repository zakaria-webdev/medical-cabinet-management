<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\RendezVous;
use App\Models\DossierMedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class ConsultationController extends Controller
{
    // Zakaria : Afficher la liste de toutes les consultations
    public function index()
    {
        // On récupère les consultations avec le médecin, le dossier (et son patient), et le rdv
        // (Ici j'ai ajouté les noms des relations dans la fonction with pour éviter les erreurs d'affichage)
        $consultations = Consultation::with(['medecin', 'dossierMedical.patient', 'rendezVous', 'ordonnance'])->get();

        return view('consultations.index', compact('consultations'));
    }

    // Zakaria : Afficher le formulaire pour créer une consultation et une ordonnance
    public function create(Request $request)
    {
        // Zakaria : Je récupère l'ID du patient depuis l'URL s'il existe (Auto-select)
        $selected_patient_id = $request->query('patient_id');

        // Zakaria : On récupère les rendez-vous du médecin connecté pour les afficher dans la liste
        $rendezVous = RendezVous::where('medecin_id', Auth::id())->get();

        // Zakaria : On récupère tous les dossiers médicaux existants avec leurs patients
        $dossiers = DossierMedical::with('patient')->get();

        return view('consultations.create', compact('rendezVous', 'dossiers', 'selected_patient_id'));
    }

    // Zakaria : Enregistrer la consultation ET l'ordonnance en même temps
    public function store(Request $request)
    {
        // Zakaria : 1. Validation stricte des données venant du formulaire
        $request->validate([
            'rdv_id' => 'required|exists:rendez_vous,id',
            'dossier_medical_id' => 'required|exists:dossier_medicals,id',
            'compte_rendu' => 'required|string',
            'date_consultation' => 'required|date',

            // Champs pour l'ordonnance (optionnels, car un médecin ne donne pas toujours des médicaments)
            'medicaments_details' => 'nullable|string',
            'notes_utilisation' => 'nullable|string',
        ]);

        // Zakaria : 2. Utilisation d'une transaction DB pour garantir que la Consultation
        // et l'Ordonnance soient créées ensemble (Sécurité des données)
        DB::beginTransaction();

        try {
            // Zakaria : A. Création de la consultation
            $consultation = Consultation::create([
                'rdv_id' => $request->rdv_id,
                'dossier_medical_id' => $request->dossier_medical_id,
                'medecin_id' => Auth::id(), // Le médecin connecté (Géré par Houcine)
                'compte_rendu' => $request->compte_rendu,
                'date_consultation' => $request->date_consultation,
            ]);

            // Zakaria : B. Création de l'ordonnance SI le médecin a rempli les médicaments
            if ($request->filled('medicaments_details')) {
                // التصحيح: هنا عمرنا البيانات ديال الوصفة
                Ordonnance::create([
                    'consultation_id' => $consultation->id,
                    'medicaments_details' => $request->medicaments_details,
                    'notes_utilisation' => $request->notes_utilisation,
                ]);
            }

            // Zakaria : Si tout est bon, on valide la transaction
            DB::commit();

            // التصحيح: التوجيه لصفحة الهيستوريك
            return redirect()->route('consultations.index')->with('success', 'Consultation et ordonnance enregistrées avec succès !');

        } catch (\Exception $e) {
            // Zakaria : En cas d'erreur, on annule tout pour éviter les données orphelines
            DB::rollback();

            // Retourner avec l'erreur pour le débogage
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage());
        }
    }
    // Zakaria : Afficher les détails d'une consultation spécifique
    public function show($id)
    {
        // On récupère la consultation avec toutes ses relations (Fail si elle n'existe pas)
        $consultation = Consultation::with(['medecin', 'dossierMedical.patient', 'rendezVous', 'ordonnance'])->findOrFail($id);

        return view('consultations.show', compact('consultation'));
    }
    // Zakaria : Générer l'ordonnance en PDF
    public function generatePDF($id)
    {
        $consultation = Consultation::with(['medecin', 'dossierMedical.patient', 'ordonnance'])->findOrFail($id);

        // S’il n’a pas d’ordonnance, nous le renverrons en lui disant qu’il n’y a pas de médicaments.
        if (!$consultation->ordonnance) {
            return back()->with('error', 'Aucune ordonnance à imprimer pour cette consultation.');
        }

        //Nous allons créer une seule page, légère pour le format PDF.
        $pdf = Pdf::loadView('consultations.pdf', compact('consultation'));
        // Afficher le fichier PDF dans le navigateur pour que
        // le médecin puisse le consulter et l'imprimer. Pour le télécharger directement,
        // cliquez sur « Télécharger ».
        return $pdf->stream('Ordonnance_Patient_'.$consultation->dossierMedical->patient->nom.'.pdf');
    }
}
