@extends("layouts.auth")

@section("titulo")
    Administra tus presupuestos
@endsection

@section("auth-contenido")
    @if(session('success'))
        <x-alert :message="session('success')" />
    @endif
@endsection