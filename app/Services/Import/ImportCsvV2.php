<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Exception;

class ImportCsvV2
{
    
    public static function createTemporaryTableFromCsv($filePath)
    {
         
        DB::beginTransaction();

        try {
            
            $data = array_map('str_getcsv', file($filePath));
            $data = array_filter($data, function ($row) {
                return array_filter($row);  
            });

            if (empty($data)) {
                throw new Exception("Le fichier CSV est vide ou mal formaté.");
            }
 
            $headers = array_map('trim', array_shift($data));
 
            $tempTableName = 'temp_' . uniqid('csv_', true);
            self::createTempTable($tempTableName, $headers);

            
            self::insertIntoTempTable($tempTableName, $data, $headers);
 
            DB::commit();

            return $tempTableName; 
        } catch (Exception $e) {
            
            DB::rollBack();
            throw $e;  
        }
    }

    
    private static function createTempTable($tableName, $headers)
    {
        $columnDefs = array_map(function ($column) {
            return "`$column` VARCHAR(255)";  
        }, $headers);

        $columnDefsString = implode(", ", $columnDefs);

         
        DB::statement("CREATE TEMPORARY TABLE $tableName ($columnDefsString)");
    }

    private static function insertIntoTempTable($tableName, $data, $headers)
    {
        $columns = implode(", ", $headers);  

        foreach ($data as $row) {
             
            $escapedValues = array_map(function ($value) {
                return "'" . addslashes($value) . "'";
            }, $row);

             
            $valuesString = implode(", ", $escapedValues);

             
            DB::statement("INSERT INTO $tableName ($columns) VALUES ($valuesString)");
        }
    }
}

