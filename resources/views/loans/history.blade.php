@extends('layouts.app')

@section('title', 'Historial de Préstamos')

@section('content')
    @if (Auth::user()->role === 'student')
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Regresar</a>
    @elseif(Auth::user()->role === 'teacher')
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">Regresar</a>
    @endif
    <div class="container">
        <h1 class="mb-4">📚 Historial de Préstamos</h1>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Libro</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr>
                        <td>{{ $loan->id }}</td>
                        <td>{{ optional($loan->book)->title ?? 'Libro eliminado' }}</td>
                        <td>{{ $loan->loaned_at }}</td>
                        <td>{{ $loan->returned_at ?? '---' }}</td>
                        <td>
                            @if ($loan->returned_at)
                                <span class="badge bg-success">Devuelto</span>
                            @else
                                <span class="badge bg-warning">Prestado</span>
                            @endif
                        </td>
                        <td>
                            @if (!$loan->returned_at)
                                <form action="{{ route('loans.return', $loan->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        🔄 Devolver
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>✔ Completado</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No tienes préstamos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
