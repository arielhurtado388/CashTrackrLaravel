<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("Mostrar la pantalla de login", function () {
    $response = $this->get(route("login"));
    $response->assertOk();
});

it("Verificar el login satisfactorio", function () {
    User::factory()->create(["email" => "ariel@ariel.com", "password" => bcrypt("1224NH.h"), "email_verified_at" => now()]);
    $response = $this->post(route("login.store"), [
        "email" => "ariel@ariel.com",
        "password" => "1224NH.h"
    ]);
    $response->assertRedirect(route("dashboard"));
    $this->assertAuthenticated();
});

it("Credenciales incorrectas en login", function () {
    User::factory()->create(["email" => "ariel@ariel.com", "password" => bcrypt("1224NH.h")]);
    $response = $this->from(route("login"))->post(route("login.store"), [
        "email" => "ariel@ariel.com",
        "password" => "password-incorrecta"
    ]);
    $response->assertRedirect(route("login"));
    $response->assertSessionHas("error", "Credenciales incorrectas");
    $this->assertGuest();
});

it("Previene el acceso a usuarios no verificados al dashboard", function () {
    User::factory()->unverified()->create(["email" => "ariel@ariel.com", "password" => bcrypt("1224NH.h")]);
    $response = $this->post(route("login.store"), [
        "email" => "ariel@ariel.com",
        "password" => "1224NH.h"
    ]);
    $response->assertRedirect(route("dashboard"));
    $this->assertAuthenticated();
    $dashboardResponse = $this->get(route("dashboard"));
    $dashboardResponse->assertRedirect(route("verification.notice"));
});

it("No permitir acceso al dashboard si el email no esta verificado", function () {
    $user = User::factory()->create([
        "email_verified_at" => null
    ]);
    $response = $this->actingAs($user)->get(route("dashboard"));
    $response->assertRedirect(route("verification.notice"));
});

it("Permitir acceso al dashboard si el email esta verificado", function () {
    $user = User::factory()->create([
        "email_verified_at" => now()
    ]);
    $response = $this->actingAs($user)->get(route("dashboard"));
    $response->assertOk();
});

it("Verificar que un usuairo exista o no", function () {
    $response = $this->from(route("login"))->post(route("login.store"), [
        "email" => "noexiste@google.com",
        "password" => "password",
    ]);
    $response->assertRedirect(route("login"));
    $response->assertSessionHasErrors(["email" => "El correo no existe"]);
    $this->assertGuest();
});