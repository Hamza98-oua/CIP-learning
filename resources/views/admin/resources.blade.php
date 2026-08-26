@extends('layouts.admin')

@section('admin-content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>{{ request()->routeIs('admin.resources.videos') ? 'Liens YouTube' : 'Ressources PDF' }}</h2>
    </div>

    <table class="glass-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Ajouté par</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(count($resources) > 0)
                @foreach($resources as $resource)
                    <tr>
                        <td>{{ $resource->title }}</td>
                        <td>
                            <span style="background: {{ $resource->type == 'pdf' ? '#ef4444' : '#3b82f6' }}; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                {{ strtoupper($resource->type) }}
                            </span>
                        </td>
                        <td>{{ $resource->user->name }}</td>
                        <td>{{ $resource->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Sûr de supprimer ?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.7rem; font-size: 0.8rem;">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem;">Aucune ressource trouvée.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
