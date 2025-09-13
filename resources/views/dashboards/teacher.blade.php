@extends('layouts.app')

@section('title', 'Panel Docente')

@section('content')

    <div class="container">
        <h1 class="mb-4">Bienvenido, Docente</h1>
        <p class="lead">Desde aquí puedes:</p>

        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ route('catalog.books.index') }}" class="btn btn-info">📚 Ver catálogo de libros</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('loans.history') }}" class="btn btn-info">📑 Ver historial de préstamos</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('reservations.index') }}" class="btn btn-info">📖 Mis Reservas</a>
            </li>
        </ul>
    </div>
@endsection
