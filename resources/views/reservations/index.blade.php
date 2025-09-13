@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
    <div class="container">
        <h1 class="mb-4">📖 Mis Reservas</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($reservations->isEmpty())
            <div class="alert alert-info">No tienes reservas activas.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Fecha de Reserva</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->reserved_at }}</td>
                            <td>
                                @if ($reservation->status === 'active')
                                    <span class="badge bg-success">Activa</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelada</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($reservation->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($reservation->status === 'active')
                                    <form action="{{ route('reservations.cancel', $reservation) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                    </form>
                                @else
                                    <em>No disponible</em>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">⬅ Volver al Panel</a>
    </div>
@endsection
