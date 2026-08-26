@extends('layouts.admin')

@section('admin-content')
<div class="glass-card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Modifier l'Utilisateur</h2>
        <a href="{{ route('admin.users.index') }}" class="btn" style="background: rgba(255,255,255,0.1);">Retour</a>
    </div>

    @if($errors->any())
        <div class="alert" style="background: rgba(239, 68, 68, 0.2); border-color: var(--danger-color); color: #fca5a5;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe <small style="color: #94a3b8;">(laissez vide pour conserver le mot de passe actuel)</small></label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="role">Rôle assigné</label>
            <select name="role" id="role" class="form-control" required>
                <option value="stagiaire" {{ old('role', $user->role) == 'stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                <option value="formateur" {{ old('role', $user->role) == 'formateur' ? 'selected' : '' }}>Formateur</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
        </div>

        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem; background: #fbbf24;">Sauvegarder les modifications</button>
    </form>
</div>
@endsection
