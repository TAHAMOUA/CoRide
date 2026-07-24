<?php

namespace Tests\Feature\Auth;

use App\Enums\RoleEmploye;
use App\Models\Entreprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_employees_can_register(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->post('/register', [
            'nom' => 'Test Employe',
            'email' => 'test@example.com',
            'entreprise_id' => $entreprise->id,
            'ville_residence' => 'Casablanca',
            'role' => RoleEmploye::Passager->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registration_requires_a_valid_entreprise(): void
    {
        $response = $this->post('/register', [
            'nom' => 'Test Employe',
            'email' => 'test2@example.com',
            'entreprise_id' => 9999,
            'ville_residence' => 'Casablanca',
            'role' => RoleEmploye::Passager->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('entreprise_id');
    }
}
