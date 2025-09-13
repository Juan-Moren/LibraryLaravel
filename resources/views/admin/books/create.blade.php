@extends('layouts.app')

@section('title','Nuevo Libro')

@section('content')
<div class="container">
    <h1>Registrar nuevo libro</h1>

    <form method="POST" action="{{ route('admin.books.store') }}">
        @csrf

        @include('admin.books.form')

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
