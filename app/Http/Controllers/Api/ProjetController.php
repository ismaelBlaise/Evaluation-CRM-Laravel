<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function data(Request $request)
    {
        // Récupérer le nombre d'éléments par page (10 par défaut)
        $perPage = $request->query('per_page', 10);

        // Retourner les projets avec pagination
        return response()->json(Project::paginate($perPage));
    }

    public function nbdata()
    {
        return response()->json([
            "nb_projects" => Project::count()
        ]);
    }
}
