@extends('layouts.main')
@section('header')
    <h1>Configuraciones</h1>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general-tab">Generales</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" aria-current="page" data-bs-toggle="tab" data-bs-target="#specialty-tab">Espcialidades</button>
                </li>
                <!-- <li class="nav-item"> -->
                <!--     <a class="nav-link" href="#"></a> -->
                <!-- </li> -->
                <!-- <li class="nav-item"> -->
                <!--     <a class="nav-link disabled" aria-disabled="true">Disabled</a> -->
                <!-- </li> -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active pt-3" id="general-tab">
                    <div class="row">
                        <div class="col">
                            <label for="">Número de Contacto</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input type="tel" class="form-control" placeholder="Ingrese Numero de Telefono">
                            </div>
                        </div>
                        <div class="col">
                            <label for="">Correo Electronico</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="nf nf-cod-mail"></i>
                                </div>
                                <input type="email" class="form-control" placeholder="Ingrese Correo Electronico">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Permitir Reservas?</label>
                            <input type="checkbox" class="form-check-input">
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                </div>

                <div class="tab-pane fade pt-3" id="specialty-tab" role="tabpanel">
                    <livewire:specialty-component></livewire:specialty-component>
                </div>

            </div>
        </div>
    </div>
@endsection
