@extends('layouts.master')

@section("content")
<div class="container mt-5">
    <h2 class="mb-4">Validation de réinitialisation</h2>

    <div class="alert alert-warning">
        <strong>Attention !</strong> Vous êtes sur le point de réinitialiser les données. Cette action est irréversible. Êtes-vous sûr de vouloir continuer ?
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form action="{{ route('reset.reset') }}" method="GET">
        @csrf

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-refresh"></i> Valider la réinitialisation
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
