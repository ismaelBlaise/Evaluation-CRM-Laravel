<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Import\ImportCsv;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImportController extends Controller
{   

    public function index(){
        return view("import.index");
    }
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048'
        ]);

         
        $path = $request->file('csv_file')->store('csv_imports');

         
        $filePath = storage_path("app/$path");

         
        $importService = new ImportCsv();
        $data = $importService->readCsv($filePath);
        if (empty($data)) {
            return back()->with('error', 'Le fichier CSV est vide ou mal formaté.');
        }

        $importService->importClients($data);

        return back()->with('success', 'Importation réussie.');
    }
}
