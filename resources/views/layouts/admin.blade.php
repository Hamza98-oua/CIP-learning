@extends('layouts.app')

@section('content')
<!-- On surcharge le conteneur principal pour éviter les marges globales si besoin -->
</div> <!-- fermeture du container global de layout.app -->

<div class="admin-layout">
    <aside class="sidebar">
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Tableau de bord
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    Tous les utilisateurs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.resources.videos') }}" class="sidebar-link {{ request()->routeIs('admin.resources.videos') ? 'active' : '' }}">
                    Liens YouTube
                </a>
            </li>
            <li>
                <a href="{{ route('admin.resources.pdfs') }}" class="sidebar-link {{ request()->routeIs('admin.resources.pdfs') ? 'active' : '' }}">
                    Ressources PDF
                </a>
            </li>
            <li style="margin-top: 2rem;">
                <a href="{{ route('admin.resources.create') }}" class="sidebar-link" style="background: rgba(59, 130, 246, 0.1); border: 1px solid var(--primary-color); text-align: center;">
                    + Ajouter une Ressource
                </a>
            </li>
        </ul>
    </aside>

    <main class="admin-content">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @yield('admin-content')
    </main>

<!-- On rouvre le container pour ne pas casser le HTML de layout.app lors de la fermeture -->
<div class="container" style="display:none;">
@endsection
