@extends('layouts.app')

@section('title', 'Catálogo de Libros')

@section('content')
    <div class="container">
        @if (Auth::user()->role === 'student')
            <a href="{{ route('student.dashboard') }}" class="btn btn-secondary mb-3">Regresar</a>
        @elseif(Auth::user()->role === 'teacher')
            <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary mb-3">Regresar</a>
        @endif

        <h1 class="mb-4">📚 Catálogo de Libros</h1>

        <form method="GET" action="{{ route('catalog.books.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="Buscar por título, autor, ISBN...">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Disponibles</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->available_copies }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('catalog.books.show', $book) }}" class="btn btn-sm btn-info me-2">
                                    Ver Detalles
                                </a>
                                @if ($book->available_copies > 0)
                                    <form action="{{ route('catalog.books.reserve', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">📌 Reservar</button>
                                    </form>
                                @else
                                    <span class="badge bg-danger">No disponible</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            @if(request('q'))
                                <div class="alert alert-warning">No se encontraron resultados para la búsqueda.</div>
                            @else
                                <div class="alert alert-info">No hay libros registrados.</div>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $books->links() }}
    </div>
@endsection
