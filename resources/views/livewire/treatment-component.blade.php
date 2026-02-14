<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="d-flex justify-content-between mb-3">
        <h3 class="text-dark"><strong>Tratamientos</strong></h3>
        <button data-bs-toggle="modal" data-bs-target="#treatment-modal" class="btn btn-primary"><i class="fa fa-plus"></i>
            Añadir Tratamiento</button>
    </div>
    <div class="card">
        <div class="card-body">
            <x-adminlte.tool.datatable :heads="['ID', 'Nombre', 'Precio (Bs)', 'Opciones']" id="treatment-table">
                @foreach ($treatments ?? [] as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#treatment-modal"
                                wire:click="getTreatment({{ $item->id }})" class="btn btn-primary"><i
                                    class="fa fa-pen"></i></button>
                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte.tool.datatable>
        </div>
    </div>

    <x-modal id="treatment-modal" title="Nuevo Tratamiento">
        <div class="modal-body">
            <div>
                <label for="">Nombre</label>
                <input type="text" class="form-control" placeholder="Ingrese el Nombre" wire:model="name">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="">Descripción</label>
                <textarea wire:model="description" class="form-control" placeholder="Ingrese Descripción"></textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="">Precio</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ingrese Precio" wire:model="price">
                    <span class="input-group-text">Bs</span>
                </div>
                @error('price')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <button wire:click="save()" class="btn btn-primary" type="">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Cancelar</button>
        </div>
    </x-modal>
</div>

@script
    <script>
        Livewire.hook('morphed', () => {
            $('#treatment-table').DataTable()
        });

        $wire.on('modalClose', () => {
            $('#treatment-modal').modal('hide');
        })
    </script>
@endscript
