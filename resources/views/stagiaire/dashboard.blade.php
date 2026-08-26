@extends('layouts.app')

@section('content')
<!-- Hero Banner -->
<div class="hero-banner">
    <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">Bienvenue, {{ Auth::user()->name }} 👋</h1>
    <p style="color: #cbd5e1; font-size: 1.1rem; max-width: 600px;">
        Prêt(e) à acquérir de nouvelles compétences ? Retrouvez ici 
        tous vos cours vidéos et documents pédagogiques à télécharger.
    </p>
</div>

<!-- Navigation Tabs & Search -->
<div class="nav-tabs">
    <button class="tab-btn active" onclick="openTab('videos-tab')">🎥 Cours Vidéos</button>
    <button class="tab-btn" onclick="openTab('pdfs-tab')">📄 Ressources PDF</button>

    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un cours..." onkeyup="filterResources()">
    </div>
</div>

<!-- Vidéos Tab Content -->
<div id="videos-tab" class="tab-content active">
    @if(count($videos) == 0)
        <div class="glass-card" style="text-align: center; color: #94a3b8; padding: 3rem;">
            <h3>Aucune vidéo disponible.</h3>
        </div>
    @else
        <div class="video-grid">
            @foreach($videos as $video)
                <div class="video-card searchable-item" data-title="{{ strtolower($video->title) }}">
                    @php
                        $url = $video->file_or_link_path;
                        if(strpos($url, 'watch?v=') !== false) {
                            $url = str_replace('watch?v=', 'embed/', $url);
                        }
                    @endphp
                    <iframe src="{{ $url }}" title="{{ $video->title }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div class="video-info">
                        <h3 style="margin-bottom: 0.5rem; font-size: 1.1rem;">{{ $video->title }}</h3>
                        <p style="font-size: 0.8rem; color: #94a3b8;">Mis en ligne le {{ $video->created_at->format('d/m/Y') }} par {{ $video->user->name ?? 'Admin' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- PDFs Tab Content -->
<div id="pdfs-tab" class="tab-content">
    @if(count($pdfs) == 0)
        <div class="glass-card" style="text-align: center; color: #94a3b8; padding: 3rem;">
            <h3>Aucun document PDF disponible.</h3>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($pdfs as $pdf)
                <div class="pdf-card searchable-item" data-title="{{ strtolower($pdf->title) }}">
                    <div>
                        <h3 style="margin-bottom: 0.3rem; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: #ef4444; color:white; padding: 0.2rem 0.4rem; border-radius: 4px; font-size:0.7rem; font-weight:800;">PDF</span>
                            {{ $pdf->title }}
                        </h3>
                        <p style="font-size: 0.8rem; color: #94a3b8;">Document de formation • Ajouté le {{ $pdf->created_at->format('d/m/Y') }}</p>
                    </div>
                    <a href="{{ asset($pdf->file_or_link_path) }}" target="_blank" class="btn" style="background: var(--primary-color);">Ouvrir le fichier</a>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Javascript Logic -->
<script>
    // Tab switching logic
    function openTab(tabName) {
        // Hide all elements with class="tab-content"
        const contents = document.getElementsByClassName("tab-content");
        for (let i = 0; i < contents.length; i++) {
            contents[i].classList.remove("active");
        }

        // Remove active class from all buttons
        const buttons = document.getElementsByClassName("tab-btn");
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
        }

        // Show the current tab, and add an "active" class to the button
        document.getElementById(tabName).classList.add("active");
        event.currentTarget.classList.add("active");
        
        // Reset search input if switching tabs (optional, but good UX)
        document.getElementById("searchInput").value = "";
        filterResources();
    }

    // Search filtering logic
    function filterResources() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        
        // Get active tab so we only filter items in the visible tab
        const activeTab = document.querySelector(".tab-content.active");
        const items = activeTab.getElementsByClassName("searchable-item");

        for (let i = 0; i < items.length; i++) {
            const title = items[i].getAttribute('data-title');
            if (title.indexOf(filter) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }
</script>
@endsection
