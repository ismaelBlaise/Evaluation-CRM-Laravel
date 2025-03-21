<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Exception;

class InsertionGenerique {

    public function insertFromTempTable($tableName, $columnDefs) {
            DB::beginTransaction();

            try {
                
                $gestionContrainte = new GestionContrainte();
                $constraintsMap = $gestionContrainte->removeAllConstraints($tableName);

                 
                $columns = DB::select("SHOW COLUMNS FROM temp");

                 
                $columnsToInsert = [];
                foreach ($columns as $column) {
                    $columnName = $column->Field;
                    foreach ($columnDefs as $def) {
                        if (strpos($columnName, $def['nom']) === 0) {
                            $columnsToInsert[$columnName] = $def['int'];
                            break;
                        }
                    }
                }

                if (empty($columnsToInsert)) {
                    return;
                }

                 
                $recordIds = [];
                foreach ($columnsToInsert as $columnName => $isId) {
                    if ($isId == 0) { 
                        $ids = DB::table("temp")->pluck($columnName)->toArray();
                        $recordIds = array_merge($recordIds, $ids);
                    }
                }
                $recordIds = array_unique(array_filter($recordIds));

                 
                $existingRecords = DB::table($tableName)->whereIn('id', $recordIds)->pluck('id')->toArray();
                $newRecordIds = array_diff($recordIds, $existingRecords);

                 
                foreach ($newRecordIds as $recordId) {
                    $data = [];
                    foreach ($columnsToInsert as $columnName => $isId) {
                        if ($isId == 0) {
                            $data['id'] = $recordId; 
                        } else {
                            
                            $data[str_replace($columnDefs[0]['nom'], '', $columnName)] = DB::table("temp")
                                ->where($columnName, $recordId)
                                ->value($columnName);
                        }
                    }
                    DB::table($tableName)->insert($data);
                }

   
                $gestionContrainte->restoreConstraints($tableName, $constraintsMap);

                DB::commit();
                echo "Les nouveaux enregistrements ont été insérés avec succès.";
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        
    }


}