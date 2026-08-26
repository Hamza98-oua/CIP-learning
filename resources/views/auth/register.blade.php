@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div class="glass-card" style="width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Créer un compte</h2>

        @if($errors->any())
            <div class="alert" style="background: rgba(239, 68, 68, 0.2); border-color: var(--danger-color); color: #fca5a5;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">S'inscrire</button>

            <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                Vous avez déjà un compte ? <a href="{{ route('login') }}" style="color: var(--accent-color); font-weight: 500; text-decoration: none;">Se connecter</a>
            </div>
        </form>
    </div>
</div>
@endsection
