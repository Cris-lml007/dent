@extends('layouts.main')
@section('header')
    <h1>Historial Medico</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="history-medic-table" :heads="$heads">
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->date }}</td>
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
