<header>
    <form action="{{route('logout')}}" method="post">
        @csrf
        <h1>Control Almacén de Mecánica</h1>
        <button class="exit-button" type="submit">
            <img src="{{ asset('img/salir.png') }}" alt="Salir">
        </button>
    </form>
</header>
