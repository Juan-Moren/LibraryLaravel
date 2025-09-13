<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // Ver historial de préstamos del usuario
    public function history(Request $request)
    {
        $loans = Loan::where('user_id', $request->user()->id)
            ->with('book')
            ->orderByDesc('borrowed_at')
            ->get();

        return view('loans.history', compact('loans'));
    }

    // Crear préstamo
    public function store(Request $request, Book $book)
    {
        $user = $request->user();

        if (!$book->isAvailable()) {
            return back()->withErrors(['msg' => 'El libro no está disponible para préstamo.']);
        }

        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(15),
            'status' => 'borrowed',
        ]);

        $book->decrementAvailable();

        return back()->with('success', 'Préstamo creado con éxito.');
    }

    // Devolver préstamo
    public function returnLoan(Loan $loan)
    {
        if ($loan->status !== 'borrowed') {
            return back()->with('error', 'Este préstamo ya fue devuelto.');
        }

        $loan->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        $loan->book->increment('available_copies');

        return back()->with('success', 'Libro devuelto con éxito.');
    }
}
