<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Paciente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function getValidator(RegisterController $controller, array $data)
    {
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('validator');
        $method->setAccessible(true);
        return $method->invoke($controller, $data);
    }

    /** @test */
    public function valida_datos_correctamente()
    {
        $controller = new RegisterController;

        $data = [
            'name' => 'Luis',
            'email' => 'luis@example.com',
            'password' => 'Luis123!',
            'password_confirmation' => 'Luis123!'
        ];

        $validator = $this->getValidator($controller, $data);

        $this->assertFalse($validator->fails(), 'La validación debería pasar con datos válidos.');
    }

    /** @test */
    public function falla_si_la_contraseña_no_es_segura()
    {
        $controller = new RegisterController;

        $data = [
            'name' => 'Luis',
            'email' => 'luis@example.com',
            'password' => '12345678', // sin mayúscula, símbolo, etc.
            'password_confirmation' => '12345678'
        ];

        $validator = $this->getValidator($controller, $data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function asigna_rol_admin_al_primer_usuario()
    {
        $controller = new RegisterController;

        $data = [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'Admin123!',
            'password_confirmation' => 'Admin123!',
        ];

        $user = $this->callProtectedMethod($controller, 'create', $data);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertDatabaseMissing('paciente', ['id_user' => $user->id]);
    }

    /** @test */
    public function asigna_rol_paciente_y_guarda_datos_en_paciente()
    {
        // Crear primer usuario (admin)
        User::factory()->create();

        $controller = new RegisterController;

        $data = [
            'name' => 'Juan',
            'email' => 'juan@example.com',
            'password' => 'Juan123!',
            'password_confirmation' => 'Juan123!',
            'paterno' => 'Pérez',
            'materno' => 'Lopez',
            'genero' => 'M',
            'edad' => 30
        ];

        $user = $this->callProtectedMethod($controller, 'create', $data);

        $this->assertTrue($user->hasRole('paciente'));
        $this->assertDatabaseHas('paciente', [
            'id_user' => $user->id,
            'nombre' => 'Juan',
            'paterno' => 'Pérez',
        ]);
    }

    protected function callProtectedMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invoke($object, $parameters);
    }
}
