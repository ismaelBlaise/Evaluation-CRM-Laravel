<?php

namespace App\Http\Controllers;

use App\Services\DatabaseService;
use App\Services\CsvImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DatabaseController extends Controller {

    public function index()
    {
        return view('databases.index');
    }

    public function resetWithTruncate()
    {
        DatabaseService::resetDatabase();
        Session::flash('flash_message', __('Base de données réinitialisée avec succès (truncate)'));
        return redirect()->route('databases.index');
    }

    public function importFromCsv(Request $request)
    {
        // Vérifie si le fichier a été correctement envoyé et qu'il est valide
        if ($request->hasFile('csv_file') && $request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $filePath = $file->storeAs('csv', 'data.csv', 'local'); // Sauvegarde dans storage/app/csv
    
            // Appeler la méthode importFromCsv pour traiter l'importation
            $result = CsvImportService::importFromCsv(storage_path("app/csv/data.csv"));
    
            // Ajouter un message de succès dans la session
            Session::flash('success', 'Importation réussie');
            Session::flash('import_message', $result);
        } else {
            // Message d'erreur si le fichier n'a pas été correctement téléchargé
            Session::flash('error', 'Erreur lors de l\'importation du fichier CSV.');
        }
    
        // Redirection vers la page principale
        return redirect()->route('databases.index');
    }
    
}
