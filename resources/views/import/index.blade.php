@extends('layouts.master')

@section("content")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded" style="border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; border-radius: 20px 20px 0 0 !important;">
                    <h3 style="font-weight: 700; text-shadow: 1px 1px 3px rgba(0,0,0,0.2);"><i class="fas fa-file-import"></i> Importation de donnees</h3>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
                    <form action="{{ route('import.upload') }}" method="POST" enctype="multipart/form-data" style="padding: 25px; border-radius: 15px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        @csrf
                        <div class="form-group">
                            <label for="file" style="font-size: 1.1rem; color: #495057; font-weight: 500;"><i class="fas fa-file-csv" style="color: #2575fc;"></i> Fichier CSV 1 (Projets)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required style="padding: 10px; border-radius: 8px; border: 1px solid #ced4da; transition: border-color 0.3s;">
                            
                            <label for="file2" style="font-size: 1.1rem; color: #495057; font-weight: 500; margin-top: 20px;"><i class="fas fa-file-csv" style="color: #2575fc;"></i> Fichier CSV 2 (Tâches)</label>
                            <input type="file" class="form-control @error('file2') is-invalid @enderror" id="file2" name="file2" required style="padding: 10px; border-radius: 8px; border: 1px solid #ced4da; transition: border-color 0.3s;">
                            
                            <label for="file3" style="font-size: 1.1rem; color: #495057; font-weight: 500; margin-top: 20px;"><i class="fas fa-file-csv" style="color: #2575fc;"></i> Fichier CSV 3 (Offres)</label>
                            <input type="file" class="form-control @error('file3') is-invalid @enderror" id="file3" name="file3" required style="padding: 10px; border-radius: 8px; border: 1px solid #ced4da; transition: border-color 0.3s;">
                            
                            @error('file')
                                <div class="invalid-feedback" style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); border: none; padding: 12px; border-radius: 10px; font-weight: 600; letter-spacing: 0.5px; transition: all 0.3s; box-shadow: 0 4px 8px rgba(37, 117, 252, 0.3);">
                            <i class="fas fa-upload"></i> Importer
                        </button>
                    </form>

                    @if(session('success') || session('error'))
                        <div class="alert @if(session('success')) alert-success @else alert-danger @endif mt-4" style="border-radius: 12px; border: none; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                            @if(session('success'))
                                <h5 style="font-weight: 700; text-align: center; color: #28a745;">
                                    <i class="fas fa-check-circle"></i> Importation réussie
                                </h5>
                            @else
                                <h5 style="font-weight: 700; text-align: center; color: #dc3545;">
                                    <i class="fas fa-exclamation-circle"></i> Erreur lors de l'importation
                                </h5>
                            @endif
                            
                            <div style="text-align: center; margin-top: 15px;">
                                <p style="font-weight: 600; margin-bottom: 5px;">Fichiers importés :</p>
                                <p style="margin-bottom: 3px;">{{ session('file_name') }}</p>
                                <p style="margin-bottom: 3px;">{{ session('file_name2') }}</p>
                                <p>{{ session('file_name3') }}</p>
                            </div>
                            
                            @if(session('success'))
                                <div style="text-align: center; margin-top: 15px;">
                                    @if(session('imported_projects_rows'))
                                        <span style="display: inline-block; background-color: #28a745; color: white; padding: 5px 10px; border-radius: 20px; margin-right: 8px; font-size: 0.85rem;">
                                            Projets: {{ session('imported_projects_rows') }} lignes
                                        </span>
                                    @endif
                                    @if(session('imported_project_tasks_rows'))
                                        <span style="display: inline-block; background-color: #28a745; color: white; padding: 5px 10px; border-radius: 20px; margin-right: 8px; font-size: 0.85rem;">
                                            Tâches: {{ session('imported_project_tasks_rows') }} lignes
                                        </span>
                                    @endif
                                    @if(session('imported_offers_rows'))
                                        <span style="display: inline-block; background-color: #28a745; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.85rem;">
                                            Offres: {{ session('imported_offers_rows') }} lignes
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            @if(session('skipped_rows'))
                                <div style="text-align: center; margin-top: 15px;">
                                    <span style="display: inline-block; background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.85rem;">
                                        Lignes en erreur: {{ session('skipped_rows') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(session('import_errors'))
                        <div style="margin-top: 30px;">
                            <h4 style="color: #dc3545; text-align: center; font-weight: 700;">
                                <i class="fas fa-exclamation-triangle"></i> Erreurs d'import
                            </h4>
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <thead style="background-color: #343a40; color: white;">
                                        <tr>
                                            <th style="padding: 12px 15px; text-align: left;">Fichier</th>
                                            <th style="padding: 12px 15px; text-align: left;">Ligne</th>
                                            <th style="padding: 12px 15px; text-align: left;">Champ</th>
                                            <th style="padding: 12px 15px; text-align: left;">Erreur</th>
                                            <th style="padding: 12px 15px; text-align: left;">Valeur incorrecte</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('import_errors') as $error)
                                            <tr style="background-color: #fff5f5; border-bottom: 1px solid #ddd;">
                                                <td style="padding: 12px 15px; color: #dc3545;">{{ $error['source_file'] ?? 'N/A' }}</td>
                                                <td style="padding: 12px 15px; color: #dc3545;">{{ $error['row']-1 }}</td>
                                                <td style="padding: 12px 15px; color: #dc3545;">{{ $error['attribute'] }}</td>
                                                <td style="padding: 12px 15px;">
                                                    <ul style="margin: 0; padding-left: 20px; color: #dc3545;">
                                                        @foreach($error['errors'] as $message)
                                                            <li>{{ $message }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td style="padding: 12px 15px; color: #dc3545;">{{ $error['values'][$error['attribute']] ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if(session('projects'))
                        <div style="margin-top: 30px;">
                            <h4 style="color: #28a745; text-align: center; font-weight: 700;">
                                <i class="fas fa-check-circle"></i> Projets importés
                            </h4>
                            <div style="overflow-x: auto;">
                                <table id="tableProjects" style="width: 100%; border-collapse: collapse; margin-top: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Ligne originale</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Nom du projet</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Client</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('projects') as $project)
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td style="padding: 12px 15px;">{{ $project->import_row }}</td>
                                                <td style="padding: 12px 15px;">{{ $project->project_title }}</td>
                                                <td style="padding: 12px 15px;">{{ $project->client_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="paginationProjects" style="display: flex; justify-content: center; margin-top: 20px;"></div>
                            </div>
                        </div>
                    @endif

                    @if(session('project_tasks'))
                        <div style="margin-top: 30px;">
                            <h4 style="color: #28a745; text-align: center; font-weight: 700;">
                                <i class="fas fa-check-circle"></i> Tâches importées
                            </h4>
                            <div style="overflow-x: auto;">
                                <table id="tableProjectTasks" style="width: 100%; border-collapse: collapse; margin-top: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Ligne originale</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Nom du projet</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Titre de la tâche</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('project_tasks') as $project_task)
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td style="padding: 12px 15px;">{{ $project_task->import_row }}</td>
                                                <td style="padding: 12px 15px;">{{ $project_task->project_title }}</td>
                                                <td style="padding: 12px 15px;">{{ $project_task->task_title }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="paginationProjectTasks" style="display: flex; justify-content: center; margin-top: 20px;"></div>
                            </div>
                        </div>
                    @endif

                    @if(session('offers'))
                        <div style="margin-top: 30px;">
                            <h4 style="color: #28a745; text-align: center; font-weight: 700;">
                                <i class="fas fa-check-circle"></i> Offres importées
                            </h4>
                            <div style="overflow-x: auto;">
                                <table id="tableOffers" style="width: 100%; border-collapse: collapse; margin-top: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Ligne originale</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Nom du client</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Titre du lead</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Type</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Produit</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Prix</th>
                                            <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: 600;">Quantité</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('offers') as $offer)
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td style="padding: 12px 15px;">{{ $offer->import_row }}</td>
                                                <td style="padding: 12px 15px;">{{ $offer->client_name }}</td>
                                                <td style="padding: 12px 15px;">{{ $offer->lead_title }}</td>
                                                <td style="padding: 12px 15px;">{{ $offer->type }}</td>
                                                <td style="padding: 12px 15px;">{{ $offer->produit }}</td>
                                                <td style="padding: 12px 15px;">{{ $offer->prix }}</td>
                                                <td style="padding: 12px 15px;">{{ $offer->quantite }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="paginationOffers" style="display: flex; justify-content: center; margin-top: 20px;"></div>
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
document.addEventListener("DOMContentLoaded", function () {
    function setupPagination(tableId, paginationId, rowsPerPage = 10) {
        let table = document.getElementById(tableId);
        if (!table) return;
        
        let pagination = document.getElementById(paginationId);
        if (!pagination) return;
        
        let rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        let totalRows = rows.length;
        let totalPages = Math.ceil(totalRows / rowsPerPage);
        let currentPage = 1;

        function showPage(page) {
            let start = (page - 1) * rowsPerPage;
            let end = start + rowsPerPage;
            for (let i = 0; i < totalRows; i++) {
                rows[i].style.display = (i >= start && i < end) ? "table-row" : "none";
            }
        }

        function renderPagination() {
            pagination.innerHTML = "";
            let ul = document.createElement("ul");
            ul.style.listStyle = "none";
            ul.style.padding = "0";
            ul.style.display = "flex";
            ul.style.gap = "5px";

            // Previous button
            if (totalPages > 1) {
                let prevLi = document.createElement("li");
                prevLi.textContent = "«";
                prevLi.style.padding = "5px 10px";
                prevLi.style.border = "1px solid #2575fc";
                prevLi.style.color = "#2575fc";
                prevLi.style.cursor = "pointer";
                prevLi.style.borderRadius = "5px";
                prevLi.style.minWidth = "35px";
                prevLi.style.textAlign = "center";
                
                if (currentPage === 1) {
                    prevLi.style.opacity = "0.5";
                    prevLi.style.cursor = "not-allowed";
                }
                
                prevLi.addEventListener("click", function () {
                    if (currentPage > 1) {
                        currentPage--;
                        showPage(currentPage);
                        updateActivePage();
                    }
                });
                ul.appendChild(prevLi);
            }

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                let li = document.createElement("li");
                li.textContent = i;
                li.style.padding = "5px 10px";
                li.style.border = "1px solid #2575fc";
                li.style.color = "#2575fc";
                li.style.cursor = "pointer";
                li.style.borderRadius = "5px";
                li.style.minWidth = "35px";
                li.style.textAlign = "center";
                
                if (i === currentPage) {
                    li.style.backgroundColor = "#2575fc";
                    li.style.color = "white";
                }
                
                li.addEventListener("click", function () {
                    currentPage = i;
                    showPage(currentPage);
                    updateActivePage();
                });
                ul.appendChild(li);
            }

            // Next button
            if (totalPages > 1) {
                let nextLi = document.createElement("li");
                nextLi.textContent = "»";
                nextLi.style.padding = "5px 10px";
                nextLi.style.border = "1px solid #2575fc";
                nextLi.style.color = "#2575fc";
                nextLi.style.cursor = "pointer";
                nextLi.style.borderRadius = "5px";
                nextLi.style.minWidth = "35px";
                nextLi.style.textAlign = "center";
                
                if (currentPage === totalPages) {
                    nextLi.style.opacity = "0.5";
                    nextLi.style.cursor = "not-allowed";
                }
                
                nextLi.addEventListener("click", function () {
                    if (currentPage < totalPages) {
                        currentPage++;
                        showPage(currentPage);
                        updateActivePage();
                    }
                });
                ul.appendChild(nextLi);
            }

            pagination.appendChild(ul);
        }

        function updateActivePage() {
            let items = pagination.querySelectorAll("li");
            items.forEach((item, index) => {
                if (item.textContent === "«" || item.textContent === "»") return;
                
                if (parseInt(item.textContent) === currentPage) {
                    item.style.backgroundColor = "#2575fc";
                    item.style.color = "white";
                } else {
                    item.style.backgroundColor = "";
                    item.style.color = "#2575fc";
                }
            });
        }

        showPage(currentPage);
        renderPagination();
    }

    // Initialize pagination for all tables
    setupPagination("tableProjects", "paginationProjects");
    setupPagination("tableProjectTasks", "paginationProjectTasks");
    setupPagination("tableOffers", "paginationOffers");
});
</script>
@endsection