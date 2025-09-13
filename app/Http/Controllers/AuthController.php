<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showChoose()
    {
        return view('choose');
    }

    public function showLoginForm(Request $request)
    {
        $role = $request->query('role', ''); // obtenemos ?role=student|teacher|admin
        return view('auth.login', compact('role'));
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Verificar que el rol coincide
            if ($request->role !== $user->role) {
                Auth::logout();
                return back()->withErrors(['email' => 'No tienes permiso para iniciar como ' . $request->role]);
            }

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['email' => 'Tu cuenta está pendiente de aprobación o inactiva.']);
            }

            // Redirigir según rol
            return match ($user->role) {
                'student' => redirect()->route('student.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'admin' => redirect()->route('admin.dashboard'),
            };
        }


        return back()->withErrors(['email' => 'Credenciales incorrectas'])->onlyInput('email');
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }



    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:student,teacher'], // admin no se registra desde aquí
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => $data['role'] === 'teacher' ? 'pending' : 'active',
        ]);


        return redirect()->route('login')->with(
            'success',
            'Registro exitoso. ' .
                ($data['role'] === 'teacher'
                    ? 'Tu cuenta está pendiente de aprobación por el administrador.'
                    : 'Ya puedes iniciar sesión.')
        );
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('choose');
    }
}
