<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Extension du contrôleur de base [cite: 312]

class AdminResourceController extends Controller
{
    /**
     * Afficher la liste des vidéos.
     */
    public function videos()
    {
        // Récupération des ressources via Eloquent [cite: 105]
        $resources = Resource::where('type', 'video')->get();

        // Retourne la vue avec les données [cite: 317, 593]
        return view('admin.resources', [
            'resources' => $resources
        ]);
    }

    /**
     * Afficher la liste des PDFs.
     */
    public function pdfs()
    {
        $resources = Resource::where('type', 'pdf')->get();

        return view('admin.resources', [
            'resources' => $resources
        ]);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Enregistrer une nouvelle ressource.
     */
    public function store(Request $request) // Injection de la requête [cite: 377, 387]
    {
        // Validation des données d'entrée [cite: 439]
        $request->validate([
            'title' => 'required',
            'type'  => 'required|in:pdf,video',
        ]);

        $path = '';

        // Logique spécifique au type PDF
        if ($request->type === 'pdf') {
            // Vérification de la présence du fichier [cite: 479]
            if (!$request->hasFile('file')) {
                return back()->withErrors(['erreur' => 'Fichier PDF manquant.'])->withInput();
            }

            // Stockage du fichier sur le disque public 
            $cheminUpload = $request->file('file')->store('pdfs', 'public');
            $path = 'storage/' . $cheminUpload;
        } 
        // Logique spécifique au type Vidéo
        elseif ($request->type === 'video') {
            if (!$request->link) {
                return back()->withErrors(['erreur' => 'Lien de la vidéo manquant.'])->withInput();
            }
            $path = $request->link;
        }

        // Création de la ressource via le modèle Eloquent [cite: 201, 332]
        $resource = new Resource();
        $resource->title = $request->title;
        $resource->description = $request->description;
        $resource->type = $request->type;
        $resource->file_or_link_path = $path;
        $resource->user_id = auth()->user()->id;
        $resource->save();

        // Redirection avec message flash de succès [cite: 559]
        if ($request->type === 'pdf') {
            return redirect('/admin/pdfs')->with('success', 'PDF ajouté avec succès.');
        }

        return redirect('/admin/videos')->with('success', 'Vidéo ajoutée avec succès.');
    }

    /**
     * Supprimer une ressource.
     */
    public function destroy($id)
    {
        // Recherche sécurisée de la ressource 
        $resource = Resource::findOrFail($id);

        if ($resource->type === 'pdf') {
            // Nettoyage du chemin pour la suppression sur le disque [cite: 118]
            $fichierPath = str_replace('storage/', '', $resource->file_or_link_path);
            Storage::disk('public')->delete($fichierPath);
        }

        $resource->delete();

        // Retour à la page précédente avec message 
        return back()->with('success', 'Ressource supprimée.');
    }
}