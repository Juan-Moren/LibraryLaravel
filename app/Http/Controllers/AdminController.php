<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;



class AdminController extends Controller
{

    // Listado de usuarios y docentes pendientes
    public function index()
    {
        $pendingTeachers = User::where('role', 'teacher')
            ->where('status', 'pending')
            ->get();

        $allUsers = User::orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', compact('pendingTeachers', 'allUsers'));
    }

    // Aprobar docente
    public function approve($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'teacher' && $user->status === 'pending') {
            $user->status = 'active';
            $user->save();
            return back()->with('success', 'Docente aprobado con éxito.');
        }

        return back()->with('error', 'No se puede aprobar este usuario.');
    }

    // Rechazar docente
    public function reject($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'teacher' && $user->status === 'pending') {
            $user->status = 'inactive';
            $user->save();
            return back()->with('error', 'Docente rechazado.');
        }

        return back()->with('error', 'No se puede rechazar este usuario.');
    }
}
