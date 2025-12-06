@extends('layouts.main')
@section('header')
    <h1>Historial Medico</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="history-medic-table" :heads="$heads">
            </x-adminlte.tool.datatable>
        </div>
    </div>
@endsection
