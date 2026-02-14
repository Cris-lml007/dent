<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="d-flex justify-content-between mb-3">
        <h3>Tratamientos</h3>
        <button data-bs-toggle="modal" data-bs-target="#treatment-modal" class="btn btn-primary"><i class="fa fa-plus"></i>
            Añadir Tratamiento</button>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <input wire:model.live="search" class="form-control" placeholder="Buscar" style="width: 300px;">
    </div>
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio (Bs)</th>
            <th>Opciones</th>
        </thead>
        <tbody>
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
        </tbody>
    </table>

    <x-modal id="treatment-modal" title="Nuevo Tratamiento">
        <div class="modal-body">
            <label for="">Nombre</label>
            <input type="text" class="form-control" placeholder="Ingrese el Nombre" wire:model="name">
            <label for="">Descripción</label>
            <textarea wire:model="description" class="form-control" placeholder="Ingrese Descripción"></textarea>
            <label for="">Precio</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Ingrese Precio" wire:model="price">
                <span class="input-group-text">Bs</span>
            </div>
        </div>
        <div class="modal-footer">
            <button wire:click="save()" class="btn btn-primary" type="">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Cancelar</button>
        </div>
    </x-modal>
</div>
