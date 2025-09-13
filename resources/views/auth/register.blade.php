@extends('layouts.app')

@section('title', 'Registrarse')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Registrarse</h2>

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mensajes de éxito --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input name="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input name="email" type="email" value="{{ old('email') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input name="password" type="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input name="password_confirmation" type="password" class="form-control" required>
                </div>

                {{-- Selección de rol --}}
                <div class="mb-3">
                    <label class="form-label">Registrarme como:</label>
                    <select name="role" class="form-select" required>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Docente</option>
                    </select>
                </div>

                {{-- Aviso para docentes --}}
                <div id="teacherNotice" class="alert alert-warning d-none">
                    Los docentes necesitarán la verificación del administrador antes de poder iniciar sesión.
                </div>

                <button class="btn btn-success w-100">Crear Cuenta</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectRole = document.querySelector("select[name='role']");
            const notice = document.getElementById("teacherNotice");

            function toggleNotice() {
                if (selectRole.value === "teacher") {
                    notice.classList.remove("d-none");
                } else {
                    notice.classList.add("d-none");
                }
            }

            selectRole.addEventListener("change", toggleNotice);
            toggleNotice(); // ejecutar al cargar
        });
    </script>
@endsection
