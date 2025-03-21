<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Exception;
class InsertionGenerique{
    public function insertUsersFromTempTable($tableName, $columnDefs)
    {
        DB::beginTransaction();

        try {
            $gestionContrainte = new GestionContrainte();
            $constraintsMap = $gestionContrainte->removeAllConstraints("$tableName");

            if (empty($columnDefs)) {
                throw new Exception("Aucune colonne spécifiée pour la récupération des utilisateurs.");
            }

            $userIds = [];
            foreach ($columnDefs as $column) {
                $ids = DB::table($tableName)->pluck($column)->toArray();
                $userIds = array_merge($userIds, $ids);
            }
            
            $userIds = array_unique(array_filter($userIds));

            if (!empty($userIds)) {
                $existingUsers = DB::table($tableName)->whereIn('id', $userIds)->pluck('id')->toArray();
                $newUserIds = array_diff($userIds, $existingUsers);

                if (!empty($newUserIds)) {
                    $newUsers = array_map(function($userId) {
                        return ['id' => $userId];
                    }, $newUserIds);
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