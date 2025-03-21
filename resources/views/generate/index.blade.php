@extends('layouts.master')

@section("content")
<div class="container mt-5">
    <h2 class="mb-4">Générer des données aléatoires</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('generate.generate') }}" method="POST">
        @csrf

        <div class="row">
            @php
                $tables = [
                    'leads', 'comments', 'mails', 'tasks', 'projects', 
                    'absences', 'contacts', 'invoice_lines', 'appointments', 
                    'payements', 'invoices', 'offers', 'clients'
                ];
            @endphp

            @foreach($tables as $table)
                <div class="col-md-4 mb-3">
                    <label for="{{ $table }}" class="form-label text-capitalize">
                        Nombre de {{ str_replace('_', ' ', $table) }} :
                    </label>
                    <input type="number" class="form-control" id="{{ $table }}" name="tables[{{ $table }}]" min="0" value="10">
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="fa fa-database"></i> Générer
        </button>
    </form>
</div>
@endsection
