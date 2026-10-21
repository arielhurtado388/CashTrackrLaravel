@extends('layouts.app')

@section('titulo')
    Administra tus presupuestos
@endsection

@section('acciones')
    <div class="sm:flex sm:items-center mt-10">
        <div class="sm:flex-auto">
            <h1 class="font-bold text-4xl">Administra tus presupuestos</h1>
            <p class="mt-2 text-xl text-gray-500">Administra tus presupuestos en esta sección</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href=""
                class="block bg-amber-500 text-white w-full px-5 py-3 rounded-lg  font-bold  text-xl cursor-pointer text-center">Nuevo
                Presupuesto</a>
        </div>
    </div>
@endsection

@section('contenido-dashboard')

@endsection