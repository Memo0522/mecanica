@extends('app')
@section('content')
    <div class="login-container">
        <div class="header-line"></div>
        <div class="login-box">
            @if ($errors->any())
                <div id="alert" class="alert alert-error" style="display: block;">
                    {{ $errors->first() }}
                </div>
            @else
                <div id="alert" class="alert"></div>
            @endif
            <form id="login-form" action="{{ route('login') }}" method="POST">
                @csrf
                <img src="img/mecanica.jpg" class="logo">
                <h1>INICIO DE SESIÓN</h1>
                <div class="input-group">
                    <img src="{{ asset('img/user.png') }}" alt="user icon">
                    <input type="text" name="user" id="usuario" placeholder="Usuario"
                        class="input-field @error('user') is-invalid @enderror" value="{{ old('user') }}" required>
                </div>
                <div class="input-group">
                    <img src="{{ asset('img/lock.png') }}" alt="password icon">
                    <input type="password" name="password" id="contrasena" placeholder="Contraseña" class="input-field"
                        required>
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
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordInput = document.getElementById('contrasena');

        showPasswordCheckbox.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>
@endsection
@endsection
