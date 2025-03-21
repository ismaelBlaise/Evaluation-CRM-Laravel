<?php

namespace App\Services;

use App\Models\Absence;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class CsvImportService
{
    public static function importFromCsv($filePath)
    {
        DB::beginTransaction(); // Démarrer la transaction
    
        try {
            $data = array_map('str_getcsv', file($filePath));

            // Supprimer les lignes vides
            $data = array_filter($data, function ($row) {
                return array_filter($row); // Supprime les lignes vides ou entièrement nulles
            });
            
            $headers = array_map('trim', $data[0]);
            unset($data[0]);
            
            if (!in_array('table_name', $headers)) {
                throw new Exception("Le fichier CSV doit contenir une colonne 'table_name'.");
            }
            
            $groupedData = [];
            $currentTable = null;
            
            foreach ($data as $row) {
                if (empty(array_filter($row))) {
                    continue; // Ignorer la ligne vide
                }
            
                if (in_array('table_name', $row)) {
                    // Nouvelle table détectée, mise à jour de l'en-tête
                    $headers = array_map('trim', $row);
                    continue;
                }
            
                $row = array_combine($headers, $row);
                $table = strtolower(trim($row['table_name']));
                
                unset($row['table_name']); // Supprimer 'table_name' pour l'insertion en DB
            
                if (!isset($groupedData[$table])) {
                    $groupedData[$table] = [];
                }
                $groupedData[$table][] = $row;
            }            
    
            // Importer les absences
            if (!empty($groupedData['absences'])) {
                self::importAbsences($groupedData['absences']);
            }
    
            // Importer les activités
            if (!empty($groupedData['activities'])) {
                self::importActivities($groupedData['activities']);
            }
    
            // Commit de la transaction si tout a bien fonctionné
            DB::commit();
    
            return "Importation terminée avec succès !";
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            DB::rollBack();
            return "Erreur lors de l'importation : " . $e->getMessage();
        }
    }

    private static function importAbsences($data)
    {
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                'external_id' => 'required|string|unique:absences,external_id',
                'reason'      => 'required|string|max:255',
                'start_at'    => 'required|date|before_or_equal:end_at',
                'end_at'      => 'required|date|after_or_equal:start_at',
                'user_id'     => 'required|exists:users,id',
                'comment'     => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                throw new Exception("Erreur de validation (Absences) : " . implode(', ', $validator->errors()->all()));
            }

            Absence::create($row);
        }
    }

    private static function importActivities($data)
    {
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                'causer_id'   => 'required|integer|exists:users,id',
                'causer_type' => 'required|string',
                'text'        => 'required|string|max:255',
                'source_type' => 'required|string',
                'source_id'   => 'required|integer',
                'properties'  => 'nullable|json',
            ]);

            if ($validator->fails()) {
                throw new Exception("Erreur de validation (Activities) : " . implode(', ', $validator->errors()->all()));
            }

            Activity::create($row);
        }
    }
}
