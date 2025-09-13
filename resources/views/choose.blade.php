@extends('layouts.app')

@section('title', 'Home - Library')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="mb-4">Bienvenido a tu Biblioteca Favorita</h1>
            <h2>¿Qué deseas hacer?</h2>
            <br>

            <!-- Botón para ir al login -->
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                Ingresar
            </a>

            <!-- Botón para ir al registro -->
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg w-100">
                Registrarse
            </a>
        </div>
    </div>
@endsection
