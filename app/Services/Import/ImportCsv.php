<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ImportCsv
{
    public function importDataFromCsv(string $filePath)
    {
        $sections = $this->readCsvSections($filePath);
        
        foreach ($sections as $tableName => $data) {
            try {
                if (empty($data)) {
                    continue;  
                }

                 
                DB::table($tableName)->insert($data);
                Log::info("Importation réussie pour la table: $tableName");
            } catch (\Exception $e) {
                Log::error("Erreur lors de l'importation dans la table $tableName: " . $e->getMessage());
            }
        }
    }

    
    public function readCsvSections(string $filePath): array
    {
        $sections = [];
        $currentTable = null;
        $currentData = [];
        $header = [];
        
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return $sections;
        }

        $handle = fopen($filePath, 'r');
        
        if ($handle !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (isset($row[0]) && $row[0] === 'table_name' && isset($row[1])) {
                    if ($currentTable) {
                        $sections[$currentTable] = $currentData;
                    }

                    $currentTable = $row[1]; 
                    $currentData = [];
                }
                elseif ($currentTable && !empty($row)) {
                    if (empty($currentData)) {
                        $header = $row;
                    } else {
                        $currentData[] = array_combine($header, $row);
                    }
                }
            }
            
            
            if ($currentTable) {
                $sections[$currentTable] = $currentData;
            }
            
            fclose($handle);
        }

        return $sections;
    }
}
