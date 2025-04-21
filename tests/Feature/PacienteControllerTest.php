<?php

namespace Tests\Feature;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function perfil_administrador()
    {
        $admin = User::factory()->create(['id' => 1]);

        $response = $this->actingAs($admin)->get(route('perfil'));

        $response->assertStatus(200);
        $response->assertViewIs('perfil.perfil');
        $response->assertViewHas('paciente', null);
        $response->assertSee($admin->email);
    }

    /** @test */
    public function perfil_usuario_con_paciente()
    {
        $user = User::factory()->create();
        $paciente = Paciente::factory()->create(['id_user' => $user->id]);

        $response = $this->actingAs($user)->get(route('perfil'));

        $response->assertStatus(200);
        $response->assertViewIs('perfil.perfil');
        $response->assertViewHas('paciente');
        $response->assertSee($paciente->paterno); // Ejemplo de dato del paciente
    }

    /** @test */
    public function actualizar_perfil()
    {
        $user = User::factory()->create();
        $paciente = Paciente::factory()->create(['id_user' => $user->id]);

        $data = [
            'email' => 'nuevo@email.com',
            'name' => 'NombreActualizado',
            'paterno' => 'ApellidoP',
            'materno' => 'ApellidoM',
            'fecha_nac' => '1995-01-01',
            'celular' => '78945612',
            'direccion' => 'Av. Siempre Viva',
        ];

        $response = $this->actingAs($user)->post(route('user-perfil'), $data);

        $response->assertRedirect(route('perfil'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $data['email'],
            'name' => $data['name'],
        ]);

        $this->assertDatabaseHas('paciente', [
            'id_user' => $user->id,
            'paterno' => $data['paterno'],
            'direccion' => $data['direccion'],
        ]);
    }
}
