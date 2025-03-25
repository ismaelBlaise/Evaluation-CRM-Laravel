<?php

namespace App\Http\Controllers;

use App\Services\Import\ImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    private $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        return view("import.index");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
            'file2' => 'required|file|mimes:csv,txt'
        ]);

        $fileName = "CSV 1 :".$request->file('file')->getClientOriginalName();
        $fileName2 = "CSV 2 :".$request->file('file2')->getClientOriginalName();

        $projectImportResult = $this->importService->importProjects($request->file('file'));
        if ($projectImportResult['error']) {
            return back()->with([
                'error' => $projectImportResult['message'],
                'import_errors' => $projectImportResult['errors'],
                'file_name' => $fileName,
                'skipped_rows' => count($projectImportResult['errors'])
            ]);
        }

        $taskImportResult = $this->importService->importProjectTasks($request->file('file2'));
        if ($taskImportResult['error']) {
            return back()->with([
                'error' => $taskImportResult['message'],
                'import_errors' => $taskImportResult['errors'],
                'file_name' => $fileName2,
                'skipped_rows' => count($taskImportResult['errors'])
            ]);
        }

        return back()->with([
            'success' => 'Importation réussie',
            'projects' => $projectImportResult['data'],
            'project_tasks' => $taskImportResult['data'],
            'file_name' => $fileName,
            'file_name2' => $fileName2,
            'imported_projects_rows' => $projectImportResult['imported_rows'],
            'imported_project_tasks_rows' => $taskImportResult['imported_rows']
        ]);
    }
}
