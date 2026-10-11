@extends("layouts.auth")

@section("titulo")
    Iniciar Sesión
@endsection

@section("auth-contenido")
    <form class="mt-14 space-y-5" novalidate>
        <div class="flex flex-col gap-2">
            <label class="font-bold text-2xl" for="correo">Correo</label>

            <input id="correo" type="email" placeholder="Tu correo" class="w-full border border-gray-300 p-3 rounded-lg"
                name="correo" tabindex="1" />
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex  items-center justify-between">
                <label class="font-bold text-2xl" for="password">Contraseña</label>
                <a href="#" class="text-indigo-950" tabindex="3">¿Olvidaste tu Contraseña?</a>
            </div>
            <input id="password" type="password" placeholder="Tu contraseña"
                class="w-full border border-gray-300 p-3 rounded-lg" name="password" tabindex="2" />
        </div>
        <input type="submit" value='Iniciar Sesión'
            class="bg-purple-950 hover:bg-purple-800 w-full p-3 rounded-lg text-white font-bold  text-xl cursor-pointer" />
    </form>
@endsection