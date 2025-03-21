<?php

namespace App\Services\Import;
use Illuminate\Support\Facades\DB;

class GestionContrainte
{
    public function removeAllConstraintsFromUsers()
    {
        
        DB::statement('SET foreign_key_checks = 0;');

        
        $columns = DB::select("SHOW CREATE TABLE users");

        $tableDefinition = $columns[0]->{'Create Table'};
        
        $constraintsMap = [];

        preg_match_all('/`(\w+)` .*? NOT NULL/', $tableDefinition, $notNullMatches);
        foreach ($notNullMatches[1] as $column) {
            $constraintsMap[$column][] = 'NOT NULL';
            DB::statement("ALTER TABLE users MODIFY `$column` VARCHAR(255) NULL");
        }

        preg_match_all('/UNIQUE KEY `(\w+)` \((.*?)\)/', $tableDefinition, $uniqueMatches);
        foreach ($uniqueMatches[2] as $index => $columns) {
            $columnList = explode(',', str_replace('`', '', $columns));
            foreach ($columnList as $column) {
                $constraintsMap[$column][] = 'UNIQUE';
            }
            DB::statement("ALTER TABLE users DROP INDEX " . $uniqueMatches[1][$index]);
        }

        preg_match_all('/CONSTRAINT `(\w+)` CHECK \((.*?)\)/', $tableDefinition, $checkMatches);
        foreach ($checkMatches[1] as $checkName) {
            DB::statement("ALTER TABLE users DROP CHECK `$checkName`");
        }

        preg_match_all('/CONSTRAINT `(\w+)` FOREIGN KEY \((.*?)\)/', $tableDefinition, $foreignKeyMatches);
        foreach ($foreignKeyMatches[1] as $foreignKeyName) {
            DB::statement("ALTER TABLE users DROP FOREIGN KEY `$foreignKeyName`");
        }

        DB::statement('SET foreign_key_checks = 1;');

        return $constraintsMap;
    }




    public function restoreConstraintsToUsers(array $constraintsMap)
    {
         
        DB::statement('SET foreign_key_checks = 0;');

         
        $columns = DB::select("SHOW COLUMNS FROM users");

         
        $columnTypes = [];
        foreach ($columns as $column) {
            $columnTypes[$column->Field] = $column->Type;
        }

         
        foreach ($constraintsMap as $column => $constraints) {
            if (in_array('NOT NULL', $constraints) && isset($columnTypes[$column])) {
                DB::statement("ALTER TABLE users MODIFY `$column` {$columnTypes[$column]} NOT NULL");
            }

            if (in_array('UNIQUE', $constraints)) {
                DB::statement("ALTER TABLE users ADD UNIQUE (`$column`)");
            }
        }

         
        DB::statement('SET foreign_key_checks = 1;');

        echo "Les contraintes ont été restaurées avec succès.";
    }

}