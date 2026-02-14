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
                @foreach ($data as $item)
                @php
                $u = $item->users()->where('role','!=',\App\Enums\Role::PATIENT)->first();
                @endphp
                <tr>
                    <td>{{ $item->ci }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ __('messages.' .$u->role->name) ?? '' }}</td>
                    <td>{{ $item->phone }}</td>
                    <td><div @class(['badge', 'badge-success'=> $u->active == 1, 'badge-danger' => $u->active == 0])>{{ $u->active == 1 ? 'Habilitado' : 'Inhabilitado' }}</div></td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('administration.staff.id', $item->id) }}"><i class="fa fa-pen"></i></a>
                    </td>
                </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="staff-modal" title="Nuevo Personal" class="modal-lg">
        <livewire:staff-component></livewire:staff-component>
    </x-modal>
@endsection
