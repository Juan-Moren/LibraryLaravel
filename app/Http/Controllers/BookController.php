<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Mostrar lista de libros
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.books.create');
    }

    // Guardar nuevo libro
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'editorial' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books',
            'publication_year' => 'nullable|digits:4|integer',
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $data['available_copies'] = $data['total_copies'];

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Libro creado con éxito');
    }

    // Mostrar formulario de edición
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    // Actualizar libro
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'editorial' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books,isbn,' . $book->id,
            'publication_year' => 'nullable|digits:4|integer',
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // ajustar copias disponibles si cambia el total
        if ($data['total_copies'] < $book->available_copies) {
            $data['available_copies'] = $data['total_copies'];
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Libro actualizado con éxito');
    }

    // Eliminar libro
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Libro eliminado con éxito');
    }

    // Catálogo para estudiantes y docentes
    public function catalogIndex()
    {
        $books = Book::latest()->paginate(10);
        return view('catalog.books.index', compact('books'));
    }

    public function catalogShow(Book $book)
    {
        return view('catalog.books.show', compact('book'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $books = \App\Models\Book::where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->orWhere('isbn', 'like', "%{$query}%")
            ->get();

        return view('books.search', compact('books', 'query'));
    }
}
