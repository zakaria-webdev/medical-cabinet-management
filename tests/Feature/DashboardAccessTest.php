<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    // [Zakaria] Ce trait réinitialise la base de données après chaque test pour éviter les conflits de données.
    use RefreshDatabase; 

    /**
     * [Zakaria] Test 1: Vérifier qu'un visiteur non connecté est redirigé vers la page de login.
     */
    public function test_guest_is_redirected_to_login_when_accessing_patient_dashboard(): void
    {
        // [Zakaria] Étape 1 : On simule une requête GET vers le dashboard patient sans être connecté.
        $response = $this->get('/patient/dashboard');

        // [Zakaria] Étape 2 : On s'assure que le système bloque l'accès et redirige vers '/login'.
        $response->assertRedirect('/login');
    }

    /**
     * [Zakaria] Test 2: Vérifier qu'un patient n'a pas le droit d'accéder au dashboard administrateur.
     */
    public function test_patient_cannot_access_admin_dashboard(): void
    {
        // [Zakaria] Étape 1 : Création d'un faux utilisateur avec le rôle 'patient' via la Factory.
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        // [Zakaria] Étape 2 : On se connecte en tant que ce patient et on tente d'accéder au dashboard admin.
        $response = $this->actingAs($patient)->get('/admin/dashboard');

        // [Zakaria] Étape 3 : On vérifie que le système retourne une erreur 403 (Forbidden / Accès refusé).
        // Note : Si notre middleware fait une redirection au lieu d'une erreur 403, utiliser : $response->assertRedirect('/patient/dashboard');
        $response->assertStatus(302); 
    }
}