@extends('layouts.base')

@section('contenido')
    <div class=" max-w-5xl mx-auto p-5 lg:p-10">
        @yield("acciones")
    </div>

    <main class=" mt-5 max-w-5xl mx-auto p-5 lg:p-10 mb-20">
        @yield("contenido-dashboard")
    </main>
@endsection