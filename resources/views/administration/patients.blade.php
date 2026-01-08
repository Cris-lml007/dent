@extends('layouts.main')
@section('header')
    <h1>Pacientes</h1>
    <a data-bs-toggle="modal" data-bs-target="#add-patient-modal" href="#" class="btn btn-primary"><i
            class="fa fa-plus"></i> Agregar Nuevo Paciente</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="patients-table" :heads="$heads">
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->ci }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ (int)\Carbon\Carbon::parse($item->birthdate)->diffInYears(\Carbon\Carbon::now()) }} años</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <a href="{{route('administration.patients.id',$item->id)}}" class="btn btn-primary"><i class="fa fa-pen"></i></a>
                            <!-- <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a> -->
                        </td>
                    </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="add-patient-modal" title="Agregar Nuevo Paciente" class="modal-lg">
        <livewire:patient-component></livewire:patient-component>
    </x-modal>
@endsection
