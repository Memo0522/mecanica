@extends('app')
@section('content')
    <div class="login-container">
        <div class="header-line"></div>
        <div class="login-box">
            <div id="alert" class="alert"></div> <!-- Contenedor para la alerta -->
            <form id="login-form" action="{{ route('login') }}" method="POST">
                @csrf
                <img src="img/mecanica.jpg" class="logo">
                <h1>INICIO DE SESIÓN</h1>
                <div class="input-group">
                    <img src="{{ asset('img/user.png') }}" alt="user icon">
                    <input type="text" name="user" id="usuario" placeholder="Usuario" class="input-field" required>
                </div>
                <div class="input-group">
                    <img src="{{ asset('img/lock.png') }}" alt="password icon">
                    <input type="password" name="password" id="contrasena" placeholder="Contraseña" class="input-field" required>
                </div>
                <div class="options">
                    <input type="checkbox" id="show-password">
                    <label for="show-password">Mostrar contraseña</label>
                </div>
                <button type="submit" class="login-button">Ingresa</button>
            </form>
        </div>
        <div class="footer-line"></div>
    </div>

    @section('scripts')
    <script>
        // Obtener el checkbox y el campo de contraseña
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordInput = document.getElementById('contrasena');

        // Escuchar cambios en el checkbox
        showPasswordCheckbox.addEventListener('change', function() {
            // Si está marcado, mostrar contraseña (texto plano)
            if (this.checked) {
                passwordInput.type = 'text';
            } 
            // Si no está marcado, ocultar contraseña (puntos)
            else {
                passwordInput.type = 'password';
            }
        });
    </script>
    @endsection
@endsection