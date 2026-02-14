@extends('layouts.main')

@section('header')
    <h1>Principal</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center align-content-center">
                            <i class="fa fa-users" style="font-size: 4rem;"></i>
                        </div>
                        <div class="col text-center align-content-center">
                            <h1><strong>{{ $sessions }}</strong></h1>
                            <h6><strong>Sesiones en Proceso</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-secondary">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center align-content-center">
                            <i class="fa fa-door-open" style="font-size: 4rem;"></i>
                        </div>
                        <div class="col text-center align-content-center">
                            <h1><strong>{{ $finish }}</strong></h1>
                            <h6><strong>Sesiones Finalizadas</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center align-content-center">
                            <i class="fa fa-money-bill" style="font-size: 4rem;"></i>
                        </div>
                        <div class="col text-center align-content-center">
                            <h1><strong>{{ $amount }} Bs</strong></h1>
                            <h6><strong>Ingreso Diario</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center align-content-center">
                            <i class="fa fa-calendar" style="font-size: 4rem;"></i>
                        </div>
                        <div class="col text-center align-content-center">
                            <h1><strong>{{ $free }}</strong></h1>
                            <h6><strong>Horarios Libres</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="schedule-table" :heads="$heads">
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->StaffSchedule->start_time . ':00 - ' . $item->StaffSchedule->end_time . ':00' }}</td>
                        <td>{{ $item->patient->name }}</td>
                        <td>{{ $item->StaffSchedule->staff->person->name }}</td>
                        <td>
                            <a href="{{ route('administration.schedule-medic.id', $item->id) }}" class="btn btn-primary"><i class="nf nf-fa-clipboard_list"></i></a>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>
@endsection
