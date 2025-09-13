@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <div class="container">
        <h1 class="mb-4">Bienvenido, Administrador</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p class="lead">Desde este panel puedes gestionar el sistema de biblioteca.</p>

        <div class="row">
            <!-- Gestión de usuarios -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">👥 Gestión de Usuarios</h5>
                        <p class="card-text">Aprobar docentes y ver usuarios registrados.</p>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Ir a Usuarios</a>
                    </div>
                </div>
            </div>

            <!-- Gestión de libros -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">📚 Gestión de Libros</h5>
                        <p class="card-text">Agregar, editar o eliminar libros.</p>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-success">Ir a Libros</a>
                    </div>
                </div>
            </div>

            <!-- Reservas y préstamos -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">📖 Reservas y Préstamos</h5>
                        <p class="card-text">Supervisar reservas y préstamos activos.</p>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-success">Ir a Reservaciones</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
