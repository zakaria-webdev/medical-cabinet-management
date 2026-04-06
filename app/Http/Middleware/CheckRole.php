<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Middleware de vérification du rôle utilisateur.
     *
     * Utilisation dans les routes :
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,medecin')
     *
     * Le rôle est stocké comme string dans la colonne "role" de la table users.
     * Valeurs possibles : admin / medecin / secretaire / patient
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // On récupère le rôle de l'utilisateur connecté depuis la table users
        $userRole = Auth::user()->role;

        // Si le rôle de l'utilisateur n'est pas dans la liste des rôles autorisés
        // on le redirige vers son propre dashboard (pas d'erreur 403 brute)
        if (!in_array($userRole, $roles)) {
            return match ($userRole) {
                'admin'      => redirect()->route('admin.dashboard'),
                'medecin'    => redirect()->route('medecin.dashboard'),
                'secretaire' => redirect()->route('secretaire.dashboard'),
                'patient'    => redirect()->route('patient.dashboard'),
                default      => redirect()->route('login'),
            };
        }

        // Le rôle est autorisé, on laisse passer la requête
        return $next($request);
    }
}
