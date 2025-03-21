<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class InsertionGenerique {

    public function insertFromTempTable($tableName, $columnDefs) {
        DB::beginTransaction();

        try {
            // Gestion des contraintes
            $gestionContrainte = new GestionContrainte();
            $constraintsMap = $gestionContrainte->removeAllConstraints($tableName);

            // Récupération des colonnes de la table temporaire
            $columns = DB::select("SHOW COLUMNS FROM temp");

            // Initialisation des variables
            $idName = "";
            $columnsToInsert = [];

            // Filtrage des colonnes à insérer
            foreach ($columns as $column) {
                $columnName = $column->Field;
                foreach ($columnDefs as $def) {
                    if ($columnName === $def['nom']) {
                        if ($def['int'] == 0) {
                            $idName = $def['nom']; // Nom de la colonne d'identifiant
                        }
                        $columnsToInsert[$columnName] = $def['int'];
                        break;
                    }
                }
            }

            // Si aucune colonne à insérer, on quitte
            if (empty($columnsToInsert)) {
                Log::warning("Aucune colonne à insérer trouvée dans la table 'temp'.");
                return;
            }

            // Récupération des IDs des enregistrements
            $recordIds = [];
            if (!empty($idName)) {
                if (Schema::hasColumn('temp', $idName)) {
                    $ids = DB::table("temp")->pluck($idName)->toArray();
                    $recordIds = array_unique(array_filter($ids)); // Suppression des doublons et des valeurs vides
                } else {
                    Log::error("La colonne d'identifiant '$idName' n'existe pas dans la table 'temp'.");
                    throw new Exception("La colonne d'identifiant '$idName' n'existe pas dans la table 'temp'.");
                }
            } else {
                Log::error("Aucune colonne d'identifiant trouvée dans les définitions de colonnes.");
                throw new Exception("Aucune colonne d'identifiant trouvée dans les définitions de colonnes.");
            }

            // Vérification des enregistrements existants
            $existingRecords = DB::table($tableName)->whereIn($idName, $recordIds)->pluck($idName)->toArray();
            $newRecordIds = array_diff($recordIds, $existingRecords);

            // Insertion des nouveaux enregistrements
            foreach ($newRecordIds as $recordId) {
                $data = [];
                foreach ($columnsToInsert as $columnName => $isId) {
                    if ($isId == 0) {
                        $data[$idName] = $recordId; // Colonne d'identifiant
                    } else {
                        $data[$columnName] = DB::table("temp")
                            ->where($idName, $recordId)
                            ->value($columnName);
                    }
                }
                DB::table($tableName)->insert($data);
            }

            // Restauration des contraintes
            $gestionContrainte->restoreConstraints($tableName, $constraintsMap);

            // Validation de la transaction
            DB::commit();
            Log::info("Les nouveaux enregistrements ont été insérés avec succès dans la table '$tableName'.");
        } catch (Exception $e) {
            // En cas d'erreur, annulation de la transaction
            DB::rollBack();
            Log::error("Erreur lors de l'insertion des enregistrements : " . $e->getMessage());
            throw $e;
        }
    }
}