<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            "name.required" => "El nombre es obligatorio",
            "email.required" => "El correo es obligatorio",
            "email.email" => "El correo no es válido",
            "email.unique" => "El correo ya está registrado",
            "password.required" => "La contraseña es obligatoria",
            "password.confirmed" => "Las contraseñas no coinciden",
            "password.min" => "La contraseña debe tener al menos :min caracteres",
            "password.mixed" => "La contraseña debe tener al menos 1 letra mayúscula y una minúscula",
            "password.symbols" => "La contraseña debe tener al menos 1 caracter especial (^@_-,*)",
            "password.numbers" => "La contraseña debe tener al menos 1 número",
            "password.uncompromised" => "La contraseña ha aparecido en filtraciones de datos. Elige una más segura",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "confirmed", Password::min(8)->mixedCase()->symbols()->numbers()->uncompromised()],
        ];
    }
}
