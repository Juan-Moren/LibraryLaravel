<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Ver reservas del usuario
    public function index(Request $request)
    {
        $reservations = Reservation::where('user_id', $request->user()->id)
            ->with('book')
            ->orderByDesc('reserved_at')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    // Crear reserva
    public function store(Request $request, Book $book)
    {
        $user = $request->user();

        if ($user->reservations()->where('status', 'active')->count() >= 5) {
            return back()->withErrors(['msg' => 'Has alcanzado el límite de 5 reservas activas.']);
        }

        if (!$book->isAvailable()) {
            return back()->withErrors(['msg' => 'El libro no está disponible para reservar.']);
        }

        $existing = $user->reservations()
            ->where('book_id', $book->id)
            ->whereIn('status', ['active', 'fulfilled'])
            ->first();

        if ($existing) {
            return back()->withErrors(['msg' => 'Ya tienes una reserva activa o cumplida para este libro.']);
        }

        Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'active',
            'reserved_at' => now(),
        ]);

        return back()->with('success', 'Reserva creada con éxito.');
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== $request->user()->id) {
            return back()->withErrors(['msg' => 'No puedes cancelar una reserva que no es tuya.']);
        }

        if ($reservation->status !== 'active') {
            return back()->withErrors(['msg' => 'La reserva ya no está activa.']);
        }

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reserva cancelada.');
    }

    public function manage()
    {
        $reservations = \App\Models\Reservation::with('book', 'user')
            ->orderBy('reserved_at', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function fulfill(Reservation $reservation)
    {
        if ($reservation->status !== 'active') {
            return back()->with('error', 'Esta reserva ya fue procesada.');
        }

        // Crear préstamo
        $loan = \App\Models\Loan::create([
            'user_id' => $reservation->user_id,
            'book_id' => $reservation->book_id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7), // ejemplo: 7 días de préstamo
            'status' => 'borrowed',
        ]);

        // Actualizar libro
        $reservation->book->decrementAvailable();

        // Marcar reserva como cumplida
        $reservation->update(['status' => 'fulfilled']);

        return back()->with('success', 'Reserva procesada y préstamo registrado.');
    }
}
