<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Http\Controllers\Controller;

class StagiaireController extends Controller
{
    /**
     * Afficher le tableau de bord du stagiaire avec les ressources.
     */
    public function index()
    {
        // Utilisation de latest() pour trier par ID/Date décroissante (plus simple)
        $videos = Resource::where('type', 'video')->latest()->get();
        $pdfs = Resource::where('type', 'pdf')->latest()->get();

        // Transmission des données via la fonction compact()
        return view('stagiaire.dashboard', compact('videos', 'pdfs'));
    }
}