<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail LMS - Centre d'Insertion Professionnelle</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <a href="/" class="brand">CIP Learning</a>
        
        <div class="auth-buttons">
            @auth
                <span>Bonjour, {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:15px;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Déconnexion</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>
