<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RendezVous; // تأكد بلي الموديل سميتو هكا عندكم

class SecretaireController extends Controller
{
    public function dashboard()
    {
        $aujourdhui = Carbon::today();
        $heureActuelle = Carbon::now()->format('H:i:s');

        // شحال من رونديفو كاين اليوم
        $rdvAujourdhuiCount = RendezVous::whereDate('date_rdv', $aujourdhui)->count();

        // شحال من واحد كيتسنى
        $enAttenteCount = RendezVous::whereDate('date_rdv', $aujourdhui)
                                    ->where('statut', 'en_attente')
                                    ->count();

        // طابلو ديال 5 المواعيد الجايين هاد النهار
        $prochainsRdv = RendezVous::with('patient')
                                  ->whereDate('date_rdv', $aujourdhui)
                                  ->whereTime('heure_rdv', '>=', $heureActuelle)
                                  ->orderBy('heure_rdv', 'asc')
                                  ->take(5)
                                  ->get();

return view('dashboard.secretaire', compact('rdvAujourdhuiCount', 'enAttenteCount', 'prochainsRdv'));    }
}
