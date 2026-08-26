<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Gérer la vérification des rôles.
     */
    public function handle(Request $request, Closure $next, $role1 = null, $role2 = null): Response
    {
        // Vérification de l'authentification via le helper auth()
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Récupération du rôle de l'utilisateur connecté
        $userRole = auth()->user()->role;

        // Vérification si le rôle correspond à l'un des paramètres autorisés
        if ($userRole === $role1 || $userRole === $role2) {
            return $next($request);
        }

        // Accès refusé si aucun rôle ne correspond
        abort(403, 'Accès non autorisé.');
    }
}