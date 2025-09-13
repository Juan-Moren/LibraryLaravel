@extends('layouts.app')

@section('title', 'Gestión de Reservas')

@section('content')
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Regresar</a>
    <div class="container">
        <h1 class="mb-4">📖 Gestión de Reservas</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Libro</th>
                    <th>Estado</th>
                    <th>Fecha Reserva</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td>{{ $res->id }}</td>
                        <td>{{ $res->user->name }} ({{ $res->user->email }})</td>
                        <td>{{ optional($res->book)->title ?? 'Libro eliminado' }}</td>
                        <td>
                            @if ($res->status === 'active')
                                <span class="badge bg-warning">Activa</span>
                            @elseif($res->status === 'fulfilled')
                                <span class="badge bg-success">Prestada</span>
                            @else
                                <span class="badge bg-danger">Cancelada</span>
                            @endif
                        </td>
                        <td>{{ $res->reserved_at }}</td>
                        <td>
                            @if ($res->status === 'active')
                                <form action="{{ route('admin.reservations.fulfill', $res->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        ✅ Prestar
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>Procesada</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay reservas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
