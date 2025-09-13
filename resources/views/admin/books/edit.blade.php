@extends('layouts.app')

@section('title','Editar Libro')

@section('content')
<div class="container">
    <h1>Editar libro</h1>

    <form method="POST" action="{{ route('admin.books.update', $book) }}">
        @csrf @method('PUT')

        @include('admin.books.form')

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
