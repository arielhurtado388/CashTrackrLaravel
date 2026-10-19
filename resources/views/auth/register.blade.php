@extends("layouts.auth")

@section("titulo")
    Crear Cuenta
@endsection

@section("auth-contenido")
    <form method="POST" action="{{ route('register.store') }}" class="mt-14 space-y-5" novalidate>
        <div class="space-y-2">
            <label class="font-bold text-2xl block" for="name">Nombre</label>

            <input id="name" type="text" placeholder="Tu nombre" class="w-full border border-gray-300 p-3 rounded-lg"
                name="name" value="{{  old('name') }}" />
        </div>

        <x-input-error field="name" />


        <div class="space-y-2">
            <label class="font-bold text-2xl block" for="email">Correo</label>

            <input id="email" type="email" placeholder="Tu correo" class="w-full border border-gray-300 p-3 rounded-lg"
                name="email" value="{{  old('email') }}" />
        </div>

        <x-input-error field="email" />


        <div class="space-y-2">
            <label class="font-bold text-2xl block" for="password">Contraseña</label>

            <input id="password" type="password" placeholder="Tu contraseña"
                class="w-full border border-gray-300 p-3 rounded-lg" name="password" />
        </div>


        <x-input-error field="password" />


        <div class="space-y-2">
            <label class="font-bold text-2xl block" for="password_confirmation">Repetir contraseña</label>

            <input id="password_confirmation" type="password" placeholder="Repite tu contraseña"
                class="w-full border border-gray-300 p-3 rounded-lg" name="password_confirmation" />
        </div>

        <input type="submit" value='Registrarme'
            class="bg-purple-950 hover:bg-purple-800 w-full p-3 rounded-lg text-white font-bold  text-xl cursor-pointer" />
    </form>
@endsection