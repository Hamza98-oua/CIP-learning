@extends('layouts.admin')

@section('admin-content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Tous les Utilisateurs</h2>
        <a href="{{ route('admin.users.create') }}" class="btn">+ Ajouter un utilisateur</a>
    </div>

    <table class="glass-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span style="background: rgba(255,255,255,0.1); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn" style="padding: 0.3rem 0.7rem; font-size: 0.8rem; background: #fbbf24;">Éditer</a>
                            
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Sûr de supprimer cet utilisateur ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.7rem; font-size: 0.8rem;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
