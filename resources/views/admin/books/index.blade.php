@extends('layouts.app')

@section('title', 'Gestión de Libros')

@section('content')
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Regresar</a>

    <div class="container">
        <h1 class="mb-4">Gestión de Libros</h1>

        <a href="{{ route('admin.books.create') }}" class="btn btn-success mb-3">➕ Nuevo Libro</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Año</th>
                    <th>Total</th>
                    <th>Disponibles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->editorial }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->total_copies }}</td>
                        <td>{{ $book->available_copies }}</td>
                        <td>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-primary">✏️ Editar</a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">🗑️
                                    Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay libros registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $books->links() }}
    </div>
@endsection
