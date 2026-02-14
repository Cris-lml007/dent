<div>
    @if ($userLogin != App\Enums\Role::PATIENT)
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col">
                    <label for="">CI</label>
                    <input type="number" class="form-control" placeholder="Ingrese su CI" wire:model.live="ci">
                </div>
                <div class="col">
                    <label for="">Nombre Completo</label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre Completo" wire:model="name" @if($patient_id) disabled @endif>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col"><label for="">Genero</label>
                    <select name="" id="" class="form-select" wire:model="gender" @if($patient_id) disabled @endif>
                        <option value="">Seleccione un Genero</option>
                        <option value="1">Masculino</option>
                        <option value="0">Femenino</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" wire:model="birthdate" @if($patient_id) disabled @endif>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="">Telefono</label>
                    <input type="tel" class="form-control" placeholder="Ingrese su Telefono" wire:model="phone" @if($patient_id) disabled @endif>
                </div>
                <div class="col">
                    <label for="">Celular de Referencia</label>
                    <input type="tel" class="form-control" placeholder="Ingrese Celular de Referencia" wire:model="ref_phone" @if($patient_id) disabled @endif>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="">Email</label>
                    <input type="email" class="form-control" placeholder="Ingrese su Email" wire:model="email" @if($patient_id) disabled @endif>
                </div>
                <div class="col"><label for="">Estado de Cuenta</label>
                    <select name="" id="" class="form-select" wire:model="active" @if($patient_id) disabled @endif>
                        <option value="">Activo</option>
                        <option value="">Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="">Especialidad</label>
                    <select name="" id="" class="form-select" wire:model.live="specialty">
                        <option value="">Seleccione Especialidad</option>
                        @foreach ($specialties_list ?? [] as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="">Medico</label>
                    <select name="" id="" class="form-select" wire:model.live="medic">
                        <option value="">Seleccione Medico</option>
                        @foreach ($medics_list ?? [] as $item)
                        <option value="{{ $item->id }}">{{ $item->person->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="">Dia</label>
                    <input type="date" class="form-control" wire:model.live="date">
                </div>
                <div class="col">
                    <label for="">Horario</label>
                    <select class="form-select" wire:model="schedule">
                        <option value="">Seleccione Horario</option>
                        @foreach ($schedules_list ?? [] as $item)
                        <option value="{{ $item->id }}">{{ $item->start_time . ':00 - ' . $item->end_time . ':00' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" wire:click="save">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
    @endif
</div>
