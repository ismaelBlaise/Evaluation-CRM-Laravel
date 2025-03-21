<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateData extends Controller
{
    public function index(){
        return view("generate.index");
    }
}
