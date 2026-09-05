<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function Pest\Laravel\postJson;

class AuthenticationApiTest extends TestCase
{
    use RefreshDatabase;

    # TEST DONDE UNA PERSONA PUEDE REGISTRARSE
    public function test_una_persona_puede_registrarse(): void 
    {

        #ARRANGE: PREPARAMOS UN USUARIO CON LOS DATOS
        $usuario = [
            'name' => 'Limit de Prueba',
            'email' => 'limitprueba@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];

        #ACT: HACEMOS LA PETICION A LA RUTA
        $response = $this->postJson('/api/V1/register', $usuario);

        #ASSERT: VERIFICAMOS QUE LA RESPUESTA SEA CORRECTA
        $response->assertStatus(201)
                ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user' => ['id','name','email']
                ])
                ->assertJsonPath('user.name', 'Limit de Prueba')
                ->assertJsonMissingPath('user.password');

        #VALIDAMOS QUE EL USUARIO EXISTA EN LA BASE DE DATOS
        $this->assertDatabaseHas('users', ['email' => 'limitprueba@gmail.com']);
    }

    # TEST DONDE UNA PERSONA REGISTRADA PUEDE INICIAR SESSION
    public function test_una_persona_registrada_puede_iniciar_session(): void 
    {
        # ARRANGE: PREPARAMOS UN USUARIO CON EL FACTORY
        User::factory()->create([
            'email' => 'limitprueba@gmail.com',
            'password' => 'password'
        ]);

        # ACT: HACEMOS LA PETICION A LA RUTA
        $response = $this->postJson(('/api/V1/login'), [
            'email' => 'limitprueba@gmail.com',
            'password' => 'password'
        ]);

        # ASSERT: VERIFICAMOS QUE LA RESPUESTA SEA CORRECTA
        $response->assertOk()
                ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user'])
                ->assertJsonPath('token_type', 'bearer')
                ->assertJsonPath('user.email', 'limitprueba@gmail.com')
                ->assertJsonMissingPath('user.password');
    }

    # TEST DONDE UNA PERSONA AUTENTICADA PUEDE VER SU PERFIL
    public function test_una_persona_autenticada_puede_ver_su_perfil(): void 
    {
         # ARRANGE: PREPARAMOS UN USUARIO CON EL FACTORY
         $user = User::factory()->create();
         
         #HACEMOS QUE EL USUARIO TENGA UN TOKEN
         $token = auth('api')->login($user);

         $this->withToken($token)->getJson('/api/V1/profile')
                                ->assertOk()
                                ->assertJsonPath('id', $user->id)
                                ->assertJsonPath('name', $user->name)
                                ->assertJsonPath('email', $user->email)
                                ->assertJsonMissingPath('password');
    }

    # TEST DONDE UNA PERSONA QUIERE VER EL PERFIL Y NO ESTA AUTORIZADA
    public function test_una_persona_no_autenticada_quiere_ver_un_perfil(): void 
    {
        $response = $this->getJson('/api/V1/profile')->assertUnauthorized();
    }

    # TEST DONDE UNA PERSONA QUIERE REGISTRARSE CON UN EMAIL YA REGISTRADO
    public function test_una_persona_se_quiere_registrar_con_un_email_registrado(): void 
    {
        # ARRANGE: CREAMOS UN USUARIO EN LA DB
        $user = User::factory()->create(['email' => 'pedrito@gmail.com']);

        # ACT: INTENTAMOS REGISTRAR UN USUARIO CON EL MISMO GMAIL QUE EL DE ARRIBA
        $response = $this->postJson('/api/V1/register', [
            'name' => 'Pedrito Real',
            'email' => 'pedrito@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        # ASSERT: ESPERAMOS UN ERROR 422
        $response->assertUnprocessable()
                ->assertJsonValidationErrors(['email']);
    }

    #TEST DONDE SE RECHAZAN LAS CREDENCIALES INCORRECTAS EN EL INICIO DE SESSION
    public function test_el_inicio_session_rechaza_credenciales_incorrectas(): void 
    {
        # ARRANGE: CREAMOS UN USUARIO REGISTRADO
        $user = [
            'email' => 'limitprueba@gmail.com',
            'password' => 'contraseña_incorrecta'
        ];

        # ACT: REALIZAMOS LA PETICION EN EL INCIAR SESSION
        $response = $this->postJson('/api/V1/login', $user);

        # ASSERT: AL ESTAR MAL LAS CREDENCIALES DEBE SER NO AUTORIZADO
        $response->assertUnauthorized();
    }

    # FUNCION QUE RECHAZA EL REGISTRO POR FALTA DE CAMPOS
    public function test_el_registro_rechaza_por_falta_del_campo_email(): void 
    {
        # ARRANGE: CREAMOS UN USUARIO 
        $user = [
            'name' => 'Pedro',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        # ACT: ENVIAMOS LA SOLICITUD DE REGISTRO
        $response = $this->postJson('/api/V1/register', $user);

        # ASSERT: VALIDAMOS LA FALTA DE CAMPOS
        $response->assertUnprocessable()
                ->assertJsonValidationErrors(['email']);
    }
}
