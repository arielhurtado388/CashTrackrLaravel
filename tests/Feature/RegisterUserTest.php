<?php

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

it("Mostrar la pantalla de registro", function () {
    $response = $this->get(route("register"));
    $response->assertOk();
    $response->assertStatus(200);
    $response->assertSee("Crear Cuenta");
    $response->assertSee("Registrarme");
    $response->assertSeeInOrder([
        "Crear Cuenta",
        "Registrarme",
    ]);
});

it("Registrar un nuevo usuario en DB", function () {
    Event::fake();
    $response = $this->post(route("register.store"), [
        "name" => "Juan Pérez",
        "email" => "juan@juan.com",
        "password" => "passwordHA.1",
        "password_confirmation" => "passwordHA.1"
    ]);
    $response->assertRedirect(route("verification.notice"));
    $user = User::where("email", "juan@juan.com")->first();
    expect($user)->not->toBeNull();
    expect($user->name)->toBe("Juan Pérez");
    expect($user->email)->toBe("juan@juan.com");
    expect($user->hasVerifiedEmail())->toBeFalse();
    Event::assertDispatched(Registered::class);
});

it("Validar los campos del formulario de registro", function () {
    $response = $this->post(route("register.store"), []);
    $response->assertSessionHasErrors([
        "name",
        "email",
        "password",
    ]);
    $response->assertSessionHasErrors([
        "name" => "El nombre es obligatorio",
        "email" => "El correo es obligatorio",
        "password" => "La contraseña es obligatoria"
    ]);
});


it("Previene un usuario con email duplicado", function () {
    User::factory()->create([
        "email" => "juan@juan.com",
    ]);
    $response = $this->post(route("register.store"), [
        "name" => "Juan Pérez",
        "email" => "juan@juan.com",
        "password" => "passwordHA.1",
        "password_confirmation" => "passwordHA.1"
    ]);
    $response->assertRedirect();
    $response->assertSessionHasErrors([
        "email" => "El correo ya está registrado"
    ]);
});

it("Enviar la notificación de verificacón de email luego del registro", function () {
    Notification::fake();
    $response = $this->post(route("register.store"), [
        "name" => "Juan Pérez",
        "email" => "juan@juan.com",
        "password" => "passwordHA.1",
        "password_confirmation" => "passwordHA.1"
    ]);
    $user = User::where("email", "juan@juan.com")->first();
    Notification::assertSentTo($user, VerifyEmail::class);
});

it("Verificacion utilizando el link enviado al email del usuario", function () {
    $user = User::factory()->unverified()->create();
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );
    $response = $this->actingAs($user)->get($verificationUrl);
    $response->assertRedirect(route('dashboard'));
    expect($user->hasVerifiedEmail())->toBeTrue();
});

it("No permite ver el dashboard a un usuario no verificado", function () {
    $user = User::factory()->unverified()->create();
    $response = $this->actingAs($user)->get(route("dashboard"));
    $response->assertRedirect(route("verification.notice"));
});

it("Permite ver el dashboard a un usuario verificado", function () {
    $user = User::factory()->create([
        "email_verified_at" => now()
    ]);
    $response = $this->actingAs($user)->get(route("dashboard"));
    $response->assertOk();
});