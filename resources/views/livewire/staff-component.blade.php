<div>
    <div class="modal-body">
        <label for="">Información Personal</label>
        @if (session('alert-person'))
            <div class="alert alert-warning">{!! session('alert-person') !!}</div>
        @endif
        <div class="row mb-3">
            <div class="col">
                <label for="ci">CI</label>
                <input type="number" class="form-control" id="ci" placeholder="Ingrese CI" wire:model.live="ci" @if($edit) disabled @endif/>
                @error('ci')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="name">Nombre Completo</label>
                <input type="text" class="form-control" id="name" placeholder="Ingrese Nombre Completo"
                    wire:model="name" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="birthdate">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="birthdate" placeholder="Ingrese Fecha de Nacimiento"
                    wire:model="birthdate" />
                @error('birthdate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="gender">Genero</label>
                <select class="form-select" wire:model="gender" id="gender">
                    <option value="">Seleccione Genero</option>
                    <option value="1">Masculino</option>
                    <option value="0">Femenino</option>
                </select>
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="phone">Celular</label>
                <input type="tel" class="form-control" id="phone" placeholder="Ingrese Número de Celular"
                    wire:model="phone" />
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="phone-ref">Celular Referencia</label>
                <input type="tel" class="form-control" id="phone-ref" placeholder="Ingrese Número de Celular"
                    wire:model="ref_phone" />
            </div>
        </div>
        <label for="">Información de Cuenta</label>
        @if (session('alert-user'))
            <div class="alert alert-warning">{!! session('alert-user') !!}</div>
        @endif
        <div class="row mb-3">
            <div class="col">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Ingrese Número de Celular"
                    wire:model="email" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" placeholder="Ingrese contraseña"
                    wire:model="password" />
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="role">Rol</label>
                <select class="form-select" wire:model="role" id="role">
                    <option value="">Seleccione Rol</option>
                    @foreach ($roles as $item)
                        <option value="{{ $item->value }}">{{ __('messages.'.$item->name) }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="status">Estado</label>
                <select class="form-select" wire:model="status" id="status">
                    <option value="">Seleccione Estado</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <label for="">Especialidades</label>
        <div class="row mb-3">
            <div class="col">
                <!-- <label for="">Especialidad</label> -->
                <div class="input-group">
                    <select class="form-select" wire:model="specialty">
                        <option value="">Seleccione Especialidad</option>
                        @foreach ($specialties as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" wire:click="addSpecialty"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </thead>
                    <tbody>
                        @foreach ($specialties_list ?? [] as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td><button class="btn btn-danger" wire:click="removeSpecialty({{ $item['id'] }})"><i
                                            class="fa fa-trash"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <label for="">Horarios de Atención</label>
        <div class="row mb-3">
            <div class="col">
                <!-- <label for="">Dia/Hr Inicio/Hr Finalización</label> -->
                <div class="input-group">
                    <select name="" id="" class="form-select" wire:model="day">
                        <option value="">Seleccione Dia</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                    </select>
                    <select name="" id="" class="form-select" wire:model="start_time">
                        <option value="">Seleccione Hora de Inicio</option>
                        @for ($i = 6; $i < 24; $i++)
                            <option value="{{ $i }}">{{ $i }} :00</option>
                        @endfor
                    </select>
                    <select name="" id="" class="form-select" wire:model="end_time">
                        <option value="">Seleccione Hora de Finalización</option>
                        @for ($i = 6; $i < 24; $i++)
                            <option value="{{ $i }}">{{ $i }} :00</option>
                        @endfor
                    </select>
                    <button class="btn btn-primary" wire:click="addSchedule"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <th>Dia</th>
                        <th>Hr Inicio</th>
                        <th>Hr Finalización</th>
                        <th>Opciones</th>
                    </thead>
                    <tbody>
                        @foreach ($schedules_list ?? [] as $index => $item)
                        @if ($item['active'] == 0)
                            @continue
                        @endif
                            <tr>
                                <td @switch($item['day'])
                                @case(1)
                                    {{ 'Lunes' }}
                                    @break
                                @case(2)
                                    {{ 'Martes' }}
                                   @break
                               @case(3)
                                    {{ 'Miercoles' }}
                                   @break
                               @case(4)
                                   {{ 'Jueves' }}
                                   @break
                               @case(5)
                                {{ 'Viernes' }}
                                   @break
                               @case(6)
                                    {{ 'Sabado' }}
                                    @break
                       @endswitch </td>

                                <td>{{ $item['start_time'] }}:00</td>
                                <td>{{ $item['end_time'] }}:00</td>
                                <td><button class="btn btn-danger" wire:click="removeSchedule({{ $index }})"><i
                                            class="fa fa-trash"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" wire:click="saveStaff" @if (session('alert-user')) disabled @endif>Guardar</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</div>
