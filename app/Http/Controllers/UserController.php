<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RendezVous;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // [NOUVEAU] ضرورية باش نكريپتيو المودپاس

class UserController extends Controller
{
    // =============================================
    // [Houcine] Gestion des Rôles & Profils — Sprint 1
    // Seul l'admin peut accéder à ces méthodes.
    // Protection assurée par middleware role:admin dans web.php
    // =============================================

    /**
     * Affiche la liste des utilisateurs avec un système de filtre par rôle.
     */
    public function index(Request $request)
    {
        // كنبداو الاستعلام
        $query = User::query();

        // إيلا الأدمين كليكا على شي فلتر (مثلاً ?role=medecin)
        if ($request->has('role') && in_array($request->role, ['admin', 'medecin', 'secretaire', 'patient'])) {
            $query->where('role', $request->role);
        }

        // كنجيبو النتيجة وكنرتبوها بالسمية
        $users = $query->orderBy('nom')->get();

        // الأدوار اللي غانحتاجو فـ dropdown
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

    // =============================================
    // [NOUVEAU] Gestion des Profils (Création, Modification & Suppression)
    // =============================================

    /**
     * Modifier les informations d'un utilisateur (Profil)
     */
    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // باش يقبل الإيميل ديالو القديم
            'password' => 'nullable|string|min:8', // المودپاس اختياري (nullable)
        ]);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;

        // إيلا الأدمين كتب شي مودپاس جديد، غنبدلوه. إيلا خلاه خاوي، غيبقى المودپاس القديم
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Le profil de '.$user->prenom.' '.$user->nom.' a été mis à jour avec succès.');
    }

    /**
     * Créer un nouveau membre (Médecin ou Secrétaire)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:medecin,secretaire',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), // التشفير ديال المودپاس ضروري
        ]);

        return back()->with('success', 'Nouveau membre ('.$request->role.') ajouté avec succès !');
    }

    /**
     * Supprimer un membre de l'équipe
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Empêcher l'admin de se supprimer lui-même
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Action interdite : Vous ne pouvez pas supprimer votre propre compte admin.');
        }

        $user->delete();
        return back()->with('success', 'Le compte de l\'utilisateur a été supprimé définitivement.');
    }

    // =============================================
    // [Zakaria/Amine] Statistiques Dashboard Admin
    // =============================================

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
