@extends('layouts.app')

@section('title', 'Detalles del libro')

@section('content')
    <div class="container">
        <h1>{{ $book->title }}</h1>
        <p><strong>Autor:</strong> {{ $book->author }}</p>
        <p><strong>Editorial:</strong> {{ $book->editorial }}</p>
        <p><strong>Año:</strong> {{ $book->publication_year }}</p>
        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
        <p><strong>Descripción:</strong> {{ $book->description }}</p>
        <p><strong>Disponibles:</strong> {{ $book->available_copies }} / {{ $book->total_copies }}</p>

        @if ($book->reservations()->where('user_id', auth()->id())->where('status', 'active')->exists())
            <button class="btn btn-secondary" disabled>Reservado</button>
        @else
            <form method="POST" action="{{ route('catalog.books.reserve', $book) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Reservar</button>
            </form>
        @endif

        <br>

        <a href="{{ route('catalog.books.index') }}" class="btn btn-secondary">⬅ Volver al Catálogo</a>
    </div>
@endsection
