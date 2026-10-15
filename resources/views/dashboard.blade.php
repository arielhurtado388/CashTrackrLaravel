@extends("layouts.auth")

@section("titulo")
    Administra tus presupuestos
@endsection

@section("auth-contenido")
    @if(session('success'))
        <p class="my-10 text-center border border-green-400 bg-green-100 py-3 text-sm text-green-700">{{ session('success') }}
        </p>
    @endif
@endsection