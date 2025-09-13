<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\LoanController;

// Página inicial
Route::get('/', [AuthController::class, 'showChoose'])->name('choose');

// Invitados (login / register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (solo usuarios logueados)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboards por rol
Route::get('/student/dashboard', fn() => view('dashboards.student'))->name('student.dashboard');
Route::get('/teacher/dashboard', fn() => view('dashboards.teacher'))->name('teacher.dashboard');
Route::get('/admin/dashboard', fn() => view('dashboards.admin'))->name('admin.dashboard');

// Panel de administrador (usuarios, libros, reservas)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de usuarios
    Route::get('/users', [AdminController::class, 'index'])->name('users');
    Route::post('/users/{id}/approve', [AdminController::class, 'approve'])->name('users.approve');
    Route::post('/users/{id}/reject', [AdminController::class, 'reject'])->name('users.reject');

    // Gestión de libros
    Route::resource('books', BookController::class)->except(['show']);

    // Reservas (admin)
    Route::get('/reservations', [ReservationController::class, 'manage'])
        ->name('reservations.index');
    Route::post('/reservations/{reservation}/fulfill', [ReservationController::class, 'fulfill'])
        ->name('reservations.fulfill');
});

// Catálogo público (estudiantes y docentes)
Route::middleware(['auth'])->prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/books', [BookController::class, 'catalogIndex'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'catalogShow'])->name('books.show');
    Route::post('/books/{book}/reserve', [ReservationController::class, 'store'])->name('books.reserve');

    // 🔍 Búsqueda de libros
    Route::get('/search', [BookController::class, 'search'])->name('books.search');
});

// Catálogo público general (para invitados o referencia)
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Reservas de estudiantes/docentes
Route::middleware(['auth'])->prefix('reservations')->name('reservations.')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('index'); // listado
    Route::post('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel'); // cancelar
});

// Préstamos
Route::middleware(['auth'])->prefix('loans')->name('loans.')->group(function () {
    Route::post('/{book}/store', [LoanController::class, 'store'])->name('store'); // crear préstamo
    Route::post('/{loan}/return', [LoanController::class, 'returnLoan'])->name('return'); // devolver
    Route::get('/history', [LoanController::class, 'history'])->name('history'); // historial
});
