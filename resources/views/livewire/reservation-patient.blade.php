<div>
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Medico</th>
            <th>Opciones</th>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->StaffSchedule->start_time . ':00 - ' . $item->StaffSchedule->end_time . ':00' }}</td>
                    <td>{{ $item->StaffSchedule->staff->person->name }}</td>
                    @if (\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($item->date)) > 2)
                        <td><a wire:click="remove({{ $item->id }})" class="btn btn-danger"><i
                                    class="nf nf-fa-trash"></i></a></td>
                    @else
                        <td><span class="text-muted">No se puede eliminar</span></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <x-modal id="schedule-modal" title="Agregar Cita Medica" class="modal-lg">
        <livewire:schedule-component></livewire:schedule-component>
    </x-modal>
</div>
