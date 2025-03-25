@extends('layouts.master')

@section("content")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h3><i class="fas fa-file-import"></i> Importer des donnees</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('import.upload') }}" method="POST" enctype="multipart/form-data" class="p-3 border rounded bg-light">
                        @csrf
                        <div class="form-group">
                            <label for="file" class="h5"><i class="fas fa-file-csv"></i> Fichier CSV 1</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                            <label for="file2" class="h5 mt-3"><i class="fas fa-file-csv"></i> Fichier CSV 2</label>
                            <input type="file" class="form-control @error('file2') is-invalid @enderror" id="file2" name="file2" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3"><i class="fas fa-upload"></i> Importer</button>
                    </form>

                    @if(session('success') || session('error'))
                        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} mt-4 text-center">
                            <h5 class="font-weight-bold">Fichier importé : <strong>{{ session('file_name')  }}</strong></h5>
                            {{ session('success') ?? session('error') }}
                            @if(session('imported_projects_rows'))
                                <br><span class="badge badge-success">Lignes de projets importées : {{ session('imported_projects_rows') }}</span>
                            @endif
                            @if(session('skipped_rows'))
                                <br><span class="badge badge-danger">Lignes en erreur : {{ session('skipped_rows') }}</span>
                            @endif
                        </div>
                    @endif

                    @if(session('import_errors'))
                        <div class="mt-4">
                            <h4 class="text-danger text-center"><i class="fas fa-exclamation-triangle"></i> Erreurs d'import</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Ligne</th>
                                            <th>Champ</th>
                                            <th>Erreur</th>
                                            <th>Valeur incorrecte</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('import_errors') as $error)
                                            <tr class="table-danger">
                                                <td>{{ $error['row']-1 }}</td>
                                                <td>{{ $error['attribute'] }}</td>
                                                <td>
                                                    <ul class="mb-0">
                                                        @foreach($error['errors'] as $message)
                                                            <li>{{ $message }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $error['values'][$error['attribute']] ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if(session('projects'))
                        <div class="mt-4">
                            <h4 class="text-success text-center"><i class="fas fa-check-circle"></i> Données importées</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Ligne originale</th>
                                            <th>Nom du projet</th>
                                            <th>Client</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('projects') as $project)
                                            <tr>
                                                <td>{{ $project->import_row }}</td>
                                                <td>{{ $project->project_title }}</td>
                                                <td>{{ $project->client_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success mt-4 text-center">
                            <h5 class="font-weight-bold">Fichier importé : <strong>{{  session('file_name2') }}</strong></h5>
                            {{ session('success') ?? session('error') }}
                            @if(session('imported_project_tasks_rows'))
                                <br><span class="badge badge-success">Lignes de projets importées : {{ session('imported_project_tasks_rows') }}</span>
                            @endif
                            
                        </div>
                    @endif

                    @if(session('project_tasks'))
                        <div class="mt-4">
                            <h4 class="text-success text-center"><i class="fas fa-check-circle"></i> Données importées</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Ligne originale</th>
                                            <th>Nom du projet</th>
                                            <th>titre de la tache</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('project_tasks') as $project_task)
                                            <tr>
                                                <td>{{ $project_task->import_row }}</td>
                                                <td>{{ $project_task->project_title }}</td>
                                                <td>{{ $project_task->task_title }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.table-responsive table').each(function() {
        $(this).DataTable({
            "paging": true,
            "pageLength": 10, // Nombre de lignes par page
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/French.json"
            }
        });
    });
});
</script>
@endsection
