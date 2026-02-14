@extends('layouts.main')

@section('header')
    <h1>Agenda Medica</h1>
    <a data-bs-toggle="modal" data-bs-target="#schedule-modal" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Agregar
        Nueva Cita</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="schedule-table" :heads="$heads" :config="['order' => [[2, 'desc']]]">
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->StaffSchedule->start_time . ':00 - ' . $item->StaffSchedule->end_time . ':00' }}</td>
                        <td>{{ $item->patient->name }}</td>
                        <td>{{ $item->StaffSchedule->staff->person->name }}</td>
                        <td>
                            @if ($is_medic)
                            <a href="{{ route('administration.schedule-medic.id', $item->id) }}" class="btn btn-primary"><i class="nf nf-fa-clipboard_list"></i></a>
                            @endif
                            @if($item->history()->count() < 1)
                            <a href="{{ route('administration.schedule-medic.delete', $item->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="schedule-modal" title="Agregar Cita Medica" class="modal-lg">
        <livewire:schedule-component></livewire:schedule-component>
    </x-modal>
@endsection
