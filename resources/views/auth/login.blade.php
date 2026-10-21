@extends("layouts.auth")

@section("titulo")
    Iniciar Sesión
@endsection

@section("auth-contenido")


    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-14 space-y-5" novalidate>
        @csrf
        <div class="flex flex-col gap-2">
            <label class="font-bold text-2xl" for="email">Correo</label>

            <input id="email" type="email" placeholder="Tu correo" class="w-full border border-gray-300 p-3 rounded-lg"
                name="email" tabindex="1" value="{{ old('email') }}" />
        </div>

        <x-input-error field="email" />

        <div class="flex flex-col gap-2">
            <div class="flex  items-center justify-between">
                <label class="font-bold text-2xl" for="password">Contraseña</label>
                <a href="#" class="text-indigo-950" tabindex="3">¿Olvidaste tu Contraseña?</a>
            </div>
            <input id="password" type="password" placeholder="Tu contraseña"
                class="w-full border border-gray-300 p-3 rounded-lg" name="password" tabindex="2" />
        </div>

        <x-input-error field="password" />

        <input type="submit" value='Iniciar Sesión'
            class="bg-purple-950 hover:bg-purple-800 w-full p-3 rounded-lg text-white font-bold  text-xl cursor-pointer" />
    </form>
@endsection