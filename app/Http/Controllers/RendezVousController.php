<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//*********************** */
use App\Models\RendezVous;   // <<— hadi khassha
use App\Models\Patient;      // <<— hadi khassha
use App\Models\User;         // <<— hadi khassha
//************************* */

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rendezvous = RendezVous::with(['patient', 'medecin'])
            ->orderBy('date_rdv')
            ->orderBy('heure_rdv')
            ->paginate(15);

        return view('rendezvous.index', compact('rendezvous'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('nom')->get();
        $medecins = User::where('role', 'medecin')->orderBy('nom')->get();
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

        RendezVous::create($validated);

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous créé avec succès.');
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
        $rdvs = RendezVous::with(['patient','medecin'])->get();

        $events = $rdvs->map(fn($r) => [
            'id'    => $r->id,
            'title' => $r->patient->nom.' — '.$r->medecin->nom,
            'start' => $r->date_rdv->format('Y-m-d').'T'.$r->heure_rdv,
            'color' => match($r->statut) {
                'confirmé'  => '#1D9E75',
                'annulé'    => '#E24B4A',
                'terminé'   => '#888780',
                default     => '#378ADD',
            },
            'url'   => route('rendezvous.edit', $r->id),
        ]);

        return response()->json($events);
    }


    public function calendar()
    {
        return view('rendezvous.calendar');
    }


}
