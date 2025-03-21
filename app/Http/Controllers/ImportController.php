<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Import\ImportCsv;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;

class ImportController extends Controller
{   
    private $importCsv;

    public function __construct(ImportCsv $importCsv)
    {
        $this->importCsv = $importCsv;
    }

    public function index(){
        return view("import.index");
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:10000'
        ]);

        try {
            
            $path = $request->file('csv_file')->store('csv_imports');

            $filePath = storage_path("app/$path");

            $data = $this->importCsv->readCsv($filePath);

            if (empty($data)) {
                return back()->with('error', 'Le fichier CSV est vide ou mal formaté.');
            }

            $this->importCsv->importClients($data);

            return back()->with('success', 'Importation réussie.');

        } catch (Exception $e) {
            Log::error("Erreur lors de l'importation du fichier CSV : " . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors de l\'importation. Veuillez réessayer.');
        }
    }
}
