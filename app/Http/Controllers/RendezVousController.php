<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//*********************** */
use App\Models\RendezVous;   // <<— hadi khassha
use App\Models\Patient;      // <<— hadi khassha
use App\Models\User;         // <<— hadi khassha
//************************* */
// [Houcine] Import Mail facade et Mailable pour envoi email confirmation - Sprint 2
use Illuminate\Support\Facades\Mail;
use App\Mail\RendezVousConfirme;

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $user = auth()->user();

    // [Houcine] Filtrage RDV par rôle - Sprint 2
    // Patient → voit uniquement ses propres RDV
    // Médecin → voit uniquement ses propres RDV
    // Admin / Secrétaire → voient tous les RDV
    $query = RendezVous::with(['patient', 'medecin'])
        ->orderBy('date_rdv')
        ->orderBy('heure_rdv');

    if ($user->role === 'patient') {
        $patient = Patient::where('user_id', $user->id)->firstOrFail();
        $query->where('patient_id', $patient->id);
    } elseif ($user->role === 'medecin') {
        $query->where('medecin_id', $user->id);
    }

    $rendezvous = $query->paginate(15);

    return view('rendezvous.index', compact('rendezvous'));
}

    /**
     * Show the form for creating a new resource.
     */
  public function create()
{
    $medecins = User::where('role', 'medecin')->get();

    // [Houcine] Patient ne peut prendre RDV que pour lui-même - Sprint 2
    if (auth()->user()->role === 'patient') {
        $patient = Patient::where('user_id', auth()->id())->firstOrFail();
        return view('rendezvous.create', compact('medecins', 'patient'));
    }

    $patients = Patient::orderBy('nom')->get();
    return view('rendezvous.create', compact('patients', 'medecins'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:users,id',
            'date_rdv'   => 'required|date|after_or_equal:today',
            'heure_rdv'  => 'required',
            'motif'      => 'nullable|string|max:500',
            // 'statut' => ... ← SUPPRIMER cette ligne
        ]);

        // On force le statut à 'en_attente' automatiquement
        $validated['statut'] = 'en_attente';

        $conflit = RendezVous::where('medecin_id', $validated['medecin_id'])
            ->where('date_rdv',   $validated['date_rdv'])
            ->where('heure_rdv',  $validated['heure_rdv'])
            ->whereNotIn('statut', ['annulé'])
            ->exists();

        if ($conflit) {
            return back()
                ->withErrors(['heure_rdv' => 'Ce médecin a déjà un RDV à ce créneau.'])
                ->withInput();
        }
    // [Houcine] Sécurité serveur: forcer patient_id si rôle = patient
// Ne jamais faire confiance au HTML seul - validation côté serveur obligatoire
if (auth()->user()->role === 'patient') {
    $patient = Patient::where('user_id', auth()->id())->firstOrFail();
    $validated['patient_id'] = $patient->id;
}

   // Créer le RDV en base de données
// create() retourne l'objet RendezVous créé avec son ID généré
$rendezVous = RendezVous::create($validated);

// [Houcine] Envoi email de confirmation après création du RDV - Sprint 2
// On recharge les relations patient et medecin car create() ne les charge pas
// sans eager loading → $rendezVous->patient serait null sans load()
$rendezVous->load(['patient', 'medecin']);

// Mail::to() = définit le destinataire de l'email
// On envoie au médecin concerné par le RDV
// ->send() = envoie immédiatement (synchrone, pas de queue)
// new RendezVousConfirme($rendezVous) = instancie le Mailable avec le RDV
if ($rendezVous->medecin && $rendezVous->medecin->email) {
    Mail::to($rendezVous->medecin->email)
        ->send(new RendezVousConfirme($rendezVous));
}

return redirect()->route('rendezvous.index')
    ->with('success', 'Rendez-vous créé avec succès. Email de confirmation envoyé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RendezVous $rendezVous)
    {
      $rendezVous->load(['patient', 'medecin']);
      return view('rendezvous.show', compact('rendezVous'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RendezVous $rendezVous)
    {
        $patients = Patient::orderBy('nom')->get();
        $medecins = User::where('role', 'medecin')->get();
        return view('rendezvous.edit', compact('rendezVous','patients','medecins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RendezVous $rendezVous)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:users,id',
            'date_rdv'   => 'required|date',
            'heure_rdv'  => 'required',
            'statut'     => 'required|in:en_attente,confirmé,annulé,terminé',
            'motif'      => 'nullable|string|max:500',
        ]);

        $rendezVous->update($validated);

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RendezVous $rendezVous)
    {
        $rendezVous->delete();
        return redirect()->route('rendezvous.index')->with('success','Supprimé.');
    }

 public function calendarData()
{
    $user = auth()->user();

    // [Houcine] Filtrage calendrier par rôle - Sprint 2
    $query = RendezVous::with(['patient', 'medecin']);

    if ($user->role === 'patient') {
        $patient = Patient::where('user_id', $user->id)->firstOrFail();
        $query->where('patient_id', $patient->id);
    } elseif ($user->role === 'medecin') {
        $query->where('medecin_id', $user->id);
    }

    $events = $query->get()->map(fn($r) => [
        'id'    => $r->id,
        'title' => $r->patient->nom . ' — ' . $r->medecin->nom,
        'start' => $r->date_rdv->format('Y-m-d') . 'T' . $r->heure_rdv,
        'color' => match($r->statut) {
            'confirmé' => '#1D9E75',
            'annulé'   => '#E24B4A',
            'terminé'  => '#888780',
            default    => '#378ADD',
        },
        'url' => route('rendezvous.show', $r->id),
    ]);

    return response()->json($events);
}


    public function calendar()
    {
        return view('rendezvous.calendar');
    }


}
