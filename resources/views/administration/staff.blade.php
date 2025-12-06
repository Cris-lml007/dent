@extends('layouts.main')
@section('header')
    <h1>Personal</h1>
    <button data-bs-toggle="modal" data-bs-target="#staff-modal" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar
        Nuevo Personal</button>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="staff-table" :heads="$heads">
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="staff-modal" title="Nuevo Personal" class="modal-lg">
        <div class="modal-body">
            <label for="">Información Personal</label>
            <div class="row mb-3">
                <div class="col">
                    <label for="ci">CI</label>
                    <input type="text" class="form-control" id="ci" placeholder="Ingrese CI" />
                </div>
                <div class="col">
                    <label for="ci">Nombre Completo</label>
                    <input type="text" class="form-control" id="ci" placeholder="Ingrese Nombre Completo" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="ci">Fecha de Nacimiento</label>
                    <input type="text" class="form-control" id="ci" placeholder="Ingrese Fecha de Nacimiento" />
                </div>
                <div class="col">
                    <label for="ci">Genero</label>
                    <select class="form-select">
                        <option value="">Seleccione Genero</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="ci">Celular</label>
                    <input type="text" class="form-control" id="phone" placeholder="Ingrese Número de Celular" />
                </div>
                <div class="col">
                    <label for="ci">Celular Referencia</label>
                    <input type="text" class="form-control" id="phone-ref" placeholder="Ingrese Número de Celular" />
                </div>
            </div>
            <label for="">Información de Cuenta</label>
            <div class="row mb-3">
                <div class="col">
                    <label for="ci">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingrese Número de Celular" />
                </div>
                <div class="col">
                    <label for="ci">Contraseña</label>
                    <input type="password" class="form-control" id="password" placeholder="Ingrese contraseña" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>Rol</label>
                    <select class="form-select">
                        <option value="">Seleccione Rol</option>
                    </select>
                </div>
                <div class="col">
                    <label for="ci">Estado</label>
                    <select class="form-select">
                        <option value="">Seleccione Estado</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
            <label for="">Especialidades</label>
            <div class="row mb-3">
                <div class="col">
                    <!-- <label for="">Especialidad</label> -->
                    <div class="input-group">
                        <select class="form-select">
                            <option value="">Seleccione Especialidad</option>
                        </select>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#specialty-modal"><i
                                class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <label for="">Horarios de Atención</label>
            <div class="row mb-3">
                <div class="col">
                    <!-- <label for="">Dia/Hr Inicio/Hr Finalización</label> -->
                    <div class="input-group">
                        <select name="" id="" class="form-select">
                            <option value="">Seleccione Dia</option>
                            <option value="">Lunes</option>
                            <option value="">Martes</option>
                            <option value="">Miercoles</option>
                            <option value="">Jueves</option>
                            <option value="">Viernes</option>
                            <option value="">Sabado</option>
                        </select>
                        <select name="" id="" class="form-select">
                            <option value="">Seleccione Hora de Inicio</option>
                        </select>
                        <select name="" id="" class="form-select">
                            <option value="">Seleccione Hora de Finalización</option>
                        </select>
                        <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <th>Dia</th>
                            <th>Hr Inicio</th>
                            <th>Hr Finalización</th>
                            <th>Opciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-primary">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </x-modal>
@endsection
