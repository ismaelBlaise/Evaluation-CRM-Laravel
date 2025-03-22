<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function data(){
        return response()->json([
            "tasks"=>Task::all(),
            "nb_tasks"=>Task::count()
        ]);
    }
}
