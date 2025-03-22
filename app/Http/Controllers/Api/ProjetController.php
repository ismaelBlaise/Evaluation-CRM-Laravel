<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function data(){
        return response()->json([
            "projects"=>Project::all(),
            "nb_projects"=>Project::count()
        ]);
    }
}
