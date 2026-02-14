<div>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col">
                <label for="">CI</label>
                <input type="number" class="form-control" placeholder="Ingrese su CI" wire:model="ci">
                @error('ci')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="">Nombre Completo</label>
                <input type="text" class="form-control" placeholder="Ingrese Nombre Completo" wire:model="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col"><label for="">Genero</label>
                <select name="" id="" class="form-select" wire:model="gender">
                    <option value="">Seleccione Genero</option>
                    <option value="1">Masculino</option>
                    <option value="0">Femenino</option>
                </select>
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="">Fecha de Nacimiento</label>
                <input type="date" class="form-control" wire:model="birthdate">
                @error('birthdate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="">Telefono</label>
                <input type="tel" class="form-control" placeholder="Ingrese su Telefono" wire:model="phone">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="">Celular de Referencia</label>
                <input type="tel" class="form-control" placeholder="Ingrese Celular de Referencia"
                    wire:model="ref_phone">
                @error('ref_phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="">Email</label>
                <input type="email" class="form-control" placeholder="Ingrese su Email" wire:model="email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col"><label for="">Estado de Cuenta</label>
                <select name="" id="" class="form-select" wire:model="active">
                    <option value="">Seleccione Estado</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                @error('active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @if ($edit && $patient->id != null)
            @if (!$patient->users()->where('role', \App\Enums\Role::PATIENT)->exists())
                <div class="alert alert-warning"><i class="nf nf-cod-warning"></i> Este paciente no tiene una cuenta
                    designada.</div>
            @endif
        @endif
    </div>
    @if ($patient->id != null)
        <h5 class="text-dark"><strong>Historial Medico</strong></h5>
        <div class="row mb-3">
            <div class="col">
                <x-adminlte.tool.datatable id="history-medic-table" :heads="$heads">
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->StaffSchedule->start_time . ':00 - ' . $item->StaffSchedule->end_time . ':00' }}
                            </td>
                            <td>{{ $item->patient->name }}</td>
                            <td>{{ $item->StaffSchedule->staff->person->name }}</td>
                            <td>
                                <a href="{{ route('administration.schedule-medic.id', $item->id) }}"
                                    class="btn btn-primary"><i class="nf nf-fa-clipboard_list"></i></a>
                                @if ($item->history->id != null)
                                    <a href="{{ route('administration.consultationPdf', $item->history->id) }}"
                                        class="btn btn-secondary"><i class="fa fa-file"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte.tool.datatable>
            </div>
        </div>

    @endif
    <div class="modal-footer">
        <button class="btn btn-primary" wire:click="savePatient">Guardar</button>
        @if ($patient->id == null)
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        @else
        <a href="{{ route('administration.historyPdf', $item->patient->id) }}" class="btn btn-secondary"> Generar Historial</a>
        <button class="btn btn-danger" id="btn-remove">Eliminar</button>
        @endif
    </div>
</div>
@script
    <script>
        let btnRemove = document.getElementById('btn-remove');
        if (btnRemove) {
            btnRemove.addEventListener('click', () => {
                window.Swal.fire({
                    title: 'Esta Seguro?',
                    text: 'Este seguro que desea borrar este paciente?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: 'red',
                    confirmButtonText: 'Si, Deseo Borrar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.removePatient();
                    }
                });

            });
        }
    </script>
@endscript
