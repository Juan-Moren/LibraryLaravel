@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">⬅ Regresar</a>

        <h1 class="mb-4">👥 Gestión de Usuarios</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Docentes pendientes -->
        <h3>Docentes pendientes de aprobación</h3>
        @if ($pendingTeachers->isEmpty())
            <p>No hay docentes pendientes.</p>
        @else
            <ul class="list-group mb-4">
                @foreach ($pendingTeachers as $teacher)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $teacher->name }}</strong>
                            ({{ $teacher->email }})
                        </div>
                        <div>
                            <form action="{{ route('admin.users.approve', $teacher->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Aprobar</button>
                            </form>
                            <form action="{{ route('admin.users.reject', $teacher->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Rechazar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Todos los usuarios -->
        <h3>Todos los usuarios</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role === 'admin')
                                🛡 Administrador
                            @elseif($user->role === 'teacher')
                                📘 Docente
                            @else
                                🎓 Estudiante
                            @endif
                        </td>
                        <td>
                            @if ($user->status === 'active')
                                <span class="badge bg-success">Activo</span>
                            @elseif($user->status === 'pending')
                                <span class="badge bg-warning">Pendiente</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
