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
                        <td>{{ $item[0] }}</td>
                        <td>{{ $item[1] }}</td>
                        <td>{{ $item[2] }}</td>
                        <td>
                            <a href="#" class="btn btn-primary"><i class="fa fa-pen"></i></a>
                            <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="add-patient-modal" title="Agregar Nuevo Paciente" class="modal-lg">
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <label for="">CI</label>
                    <input type="number" class="form-control" placeholder="Ingrese su CI">
                </div>
                <div class="col">
                    <label for="">Nombre Completo</label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre Completo">
                </div>
            </div>
            <div class="row">
                <div class="col"><label for="">Genero</label>
                    <select name="" id="" class="form-select">
                        <option value="">Masculino</option>
                        <option value="">Femenino</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Fecha de Nacimiento</label>
                    <input type="date" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="">Telefono</label>
                    <input type="tel" class="form-control" placeholder="Ingrese su Telefono">
                </div>
                <div class="col">
                    <label for="">Celular de Referencia</label>
                    <input type="tel" class="form-control" placeholder="Ingrese Celular de Referencia">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </x-modal>
@endsection
