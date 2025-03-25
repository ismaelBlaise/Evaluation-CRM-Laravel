<?php

namespace App\Services\Import;

use App\Imports\ProjectsImport;
use App\Imports\ProjectTasksImport;
use App\Models\TempProject;
use App\Models\TempProjectTask;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ImportService
{
    public function importProjects($file)
    {
        TempProject::truncate();
        $importProject = new ProjectsImport;

        try {
            Excel::import($importProject, $file);
            
            $errors = $this->handleImportErrors($importProject);
            if (!empty($errors)) {
                TempProjectTask::truncate();
                TempProject::truncate();
                return ['error' => true, 'message' => 'Importation annulée - Des erreurs ont été détectées', 'errors' => $errors];
            }

            return ['error' => false, 'data' => TempProject::all(), 'imported_rows' => TempProject::count()];
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'importation des projets: ' . $e->getMessage());
            return ['error' => true, 'message' => 'Erreur fatale lors de l\'import: ' . $e->getMessage()];
        }
    }

    public function importProjectTasks($file)
    {
        TempProjectTask::truncate();
        $importProjectTask = new ProjectTasksImport;

        try {
            Excel::import($importProjectTask, $file);

            $errors = $this->handleImportErrors($importProjectTask);
            if (!empty($errors)) {
                TempProjectTask::truncate();
                TempProject::truncate();
                return ['error' => true, 'message' => 'Importation annulée - Des erreurs ont été détectées', 'errors' => $errors];
            }

            return ['error' => false, 'data' => TempProjectTask::all(), 'imported_rows' => TempProjectTask::count()];
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'importation des tâches: ' . $e->getMessage());
            return ['error' => true, 'message' => 'Erreur fatale lors de l\'import: ' . $e->getMessage()];
        }
    }

    private function handleImportErrors($importInstance)
    {
        $errors = [];
        if ($importInstance->failures()->isNotEmpty()) {
            foreach ($importInstance->failures() as $failure) {
                $errors[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values()
                ];
            }
        }
        return $errors;
    }
}
