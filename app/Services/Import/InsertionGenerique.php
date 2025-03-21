<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Exception;
class InsertionGenerique{
    public function insertFromTempTable($tableName, $columnDefs)
    {
        DB::beginTransaction();

        try {
            $gestionContrainte = new GestionContrainte();
            $constraintsMap = $gestionContrainte->removeAllConstraints($tableName);

            if (empty($columnDefs)) {
                throw new Exception("Aucune colonne spécifiée pour la récupération des ". $tableName ."");
            }

            $tableIds = [];
            foreach ($columnDefs as $column) {
                $ids = DB::table($tableName)->pluck($column)->toArray();
                $tableIds = array_merge($tableIds, $ids);
            }
            
            $tableIds = array_unique(array_filter($tableIds));

            if (!empty($tableIds)) {
                $existingTables = DB::table($tableName)->whereIn('id', $tableIds)->pluck('id')->toArray();
                $newtableIds = array_diff($tableIds, $existingTables);

                if (!empty($newtableIds)) {
                    $newUsers = array_map(function($userId) {
                        return ['id' => $userId];
                    }, $newtableIds);
                    DB::table($tableName)->insert($newUsers);
                }
            }

            $gestionContrainte->restoreConstraints($tableName, $constraintsMap);
            DB::commit();
            
            echo "Les nouveaux utilisateurs ont été insérés avec succès.";
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}