@extends('layouts.admin')

@section('admin-content')
<div class="glass-card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Ajouter une Ressource</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: rgba(255,255,255,0.1);">Retour au tableau de bord</a>
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

    <form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titre de la ressource</label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="type">Type de ressource</label>
            <select name="type" id="type" class="form-control" required onchange="toggleFields()">
                <option value="video">Vidéo (Lien YouTube/Vimeo)</option>
                <option value="pdf">Document PDF (Upload)</option>
            </select>
        </div>

        <div class="form-group" id="link-group">
            <label for="link">Lien de la vidéo (URL)</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="https://www.youtube.com/embed/... ou https://youtu.be/..." value="{{ old('link') }}">
        </div>

        <div class="form-group" id="file-group" style="display: none;">
            <label for="file">Fichier PDF (Max: 10MB)</label>
            <input type="file" name="file" id="file" class="form-control" accept=".pdf">
        </div>

        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Ajouter la ressource</button>
    </form>
</div>

<script>
    function toggleFields() {
        const type = document.getElementById('type').value;
        const linkGroup = document.getElementById('link-group');
        const fileGroup = document.getElementById('file-group');

        if (type === 'video') {
            linkGroup.style.display = 'block';
            fileGroup.style.display = 'none';
        } else {
            linkGroup.style.display = 'none';
            fileGroup.style.display = 'block';
        }
    }
    // initial check
    toggleFields();
</script>
@endsection
