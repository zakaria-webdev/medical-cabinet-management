<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\RendezVous;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // =============================================
    // [Houcine] Gestion des Rôles — Sprint 1
    // Seul l'admin peut accéder à ces méthodes.
    // Protection assurée par middleware role:admin dans web.php
    // =============================================

    /**
     * Affiche la liste de tous les utilisateurs avec leur rôle actuel.
     * L'admin peut modifier le rôle de chaque utilisateur via un dropdown.
     */
    public function index()
    {
        // Récupère tous les utilisateurs triés par nom
        $users = User::orderBy('nom')->get();

        // Liste des rôles disponibles pour le dropdown
        $roles = ['admin', 'medecin', 'secretaire', 'patient'];

        return view('admin.users', compact('users', 'roles'));
    }

    /**
     * Met à jour le rôle d'un utilisateur spécifique.
     * Appelé via POST /admin/users/{user}/role
     */
    public function updateRole(Request $request, User $user)
    {
        // Validation : le rôle doit être une des 4 valeurs autorisées
        $request->validate([
            'role' => ['required', 'in:admin,medecin,secretaire,patient'],
        ]);

        // Empêcher l'admin de changer son propre rôle (sécurité)
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        // Mise à jour du rôle
        $user->update(['role' => $request->role]);

        return back()->with('success', 'Rôle de '.$user->prenom.' '.$user->nom.' mis à jour avec succès.');
    }



    /**
 * Dashboard Admin avec statistiques
 */
public function dashboard()
{
    // 1. عدد المرضى الكلي من table patients
    $totalPatients = Patient::count();

    // 2. عدد المستخدمين الكلي
    $totalUsers = User::count();

    // 3. المواعيد مجمعة حسب الحالة (statut)
    // النتيجة: ['confirmé' => 5, 'annulé' => 2, ...]
    $appointmentsByStatus = RendezVous::select('statut', DB::raw('count(*) as total'))
        ->groupBy('statut')
        ->pluck('total', 'statut')
        ->toArray();

    // 4. المواعيد حسب الشهر للسنة الحالية
    $appointmentsByMonth = RendezVous::select(
            DB::raw('MONTH(date_rdv) as month'),
            DB::raw('count(*) as total')
        )
        ->whereYear('date_rdv', date('Y'))
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

    // نحوّل لـ array من 12 شهر (شهور فارغة = 0)
    $monthlyData = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyData[] = $appointmentsByMonth[$i] ?? 0;
    }

    // 5. إجمالي المواعيد
    $totalRdv = RendezVous::count();

    return view('dashboard.admin', compact(
        'totalPatients',
        'totalUsers',
        'appointmentsByStatus',
        'monthlyData',
        'totalRdv'
    ));
}
}
