<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RendezVousTest extends TestCase
{
    // [Zakaria] On nettoie la base de données avant l'exécution du test.
    use RefreshDatabase;

    /**
     * [Zakaria] Test 3: Vérifier qu'un patient authentifié peut créer un rendez-vous avec succès.
     */
    public function test_patient_can_create_rendezvous(): void
    {
        // [Zakaria] Étape 1 : Création du User, du Patient et du Médecin.
        $userPatient = User::factory()->create(['role' => 'patient']);
        
        // Nous ajoutons cette ligne au tableau des patients afin que la validation ne nous bloque pas.
        // Si vous ne disposez pas d'une usine à patients, nous travaillerons directement avec l'utilisateur.
        $patient = \App\Models\Patient::factory()->create(['user_id' => $userPatient->id]); 
        
        $medecin = User::factory()->create(['role' => 'medecin']);

        // [Zakaria] Étape 2 : On soumet le formulaire...
        $response = $this->actingAs($userPatient)->post('/rendezvous', [
            'patient_id' => $patient->id, // Nous utilisons l'identifiant réel du patient.
            'medecin_id' => $medecin->id,
            'date_rdv'   => '2026-05-20',
            'heure_rdv'  => '10:00',
            'motif'      => 'Consultation de routine'
        ]);

        // [Zakaria] Étape 3 : On vérifie la redirection.
        $response->assertRedirect(route('rendezvous.index'));

        // [Zakaria] Étape 4 : Vérification dans la base de données.
        $this->assertDatabaseHas('rendez_vous', [ 
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => '2026-05-20',
        ]);
    }
}
