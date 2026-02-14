<div>
    <div class="d-flex justify-content-between mb-3">
        <h3 class="text-dark"><strong>Especialidades</strong></h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#specialty-modal">
            <i class="fa fa-plus"></i> Nueva Especialidad
        </button>
    </div>
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable id="specialty-table" :heads="$headSpecialty">
                @foreach ($list as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <button class="btn btn-primary" wire:click="load({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#specialty-modal"><i class="fa fa-pen"></i></button>
                        <button class="btn btn-danger" wire:click="delete({{ $item->id }})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="specialty-modal" title="Especialidad">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="Ingrese Especialidad" wire:model="title">
                    @error('title')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="">Descripción</label>
                    <textarea class="form-control" rows="2" wire:model="description"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-primary" wire:click="updateOrCreate">Guardar</button>
        </div>
    </x-modal>
</div>

@script
    <script>
        Livewire.hook('morphed', () => {
            $('#specialty-table').DataTable()
        });

        $wire.on('modalClose', () => {
            $('#specialty-modal').modal('hide');
        })
    </script>
@endscript
