<div class="mb-3">
    <style>
        .tooth {
            cursor: pointer;
        }
    </style>



    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <!-- <label for="">Información Personal</label> -->
    <h5 class="text-dark"><strong>Información Personal</strong></h5>
    <div class="row mb-3">
        <div class="col">
            <label for="">CI</label>
            <input type="number" class="form-control" placeholder="Ingrese su CI" value="{{ $patient->ci }}" disabled>
        </div>
        <div class="col">
            <label for="">Nombre Completo</label>
            <input type="text" class="form-control" placeholder="Ingrese Nombre Completo"
                value="{{ $patient->name }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col"><label for="">Genero</label>
            <select name="" id="" class="form-select" disabled>
                @if ($patient->gender == 1)
                    <option value="1">Masculino</option>
                @else
                    <option value="0">Femenino</option>
                @endif
            </select>
        </div>
        <div class="col">
            <label for="">Fecha de Nacimiento</label>
            <input type="date" class="form-control" value="{{ $patient->birthdate }}" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="">Telefono</label>
            <input type="tel" class="form-control" placeholder="Ingrese su Telefono" value="{{ $patient->phone }}"
                disabled>
        </div>
        <div class="col">
            <label for="">Celular de Referencia</label>
            <input type="tel" class="form-control" placeholder="Ingrese Celular de Referencia"
                value="{{ $patient->ref_phone }}" disabled>
        </div>
    </div>


    <div class="row mb-3">
        <div class="col">
            <label for="">Motivo de la Consulta</label>
            <textarea wire:model="description" rows="3" cols="" class="form-control"
                placeholder="Ingrese Motivo de la Consulta..." @if($status == 1) disabled @endif></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="d-flex justify-content-between">
            <h5 class="text-dark"><strong>Plan de Tratamientos</strong></h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#treatment-modal" @if($status == 1) disabled @endif><i
                    class="fa fa-plus"></i> Añadir Nuevo Tratamiento</button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-striped border">
                <thead>
                    <th>ID</th>
                    <th>Tratamiento</th>
                    <th>Precio</th>
                    <th>Tratar</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($treatments ?? [] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->treatment->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                <button wire:click="toggleTreatment({{ $item->id }})" @class([
                                    'btn',
                                    'btn-primary' => in_array($item->id, $treatments_used),
                                    'btn-danger' => !in_array($item->id, $treatments_used),
                                ])
                                    @if ($item->status == 2 || $status == 1) disabled @endif><i
                                        @class([
                                            'nf',
                                            'nf-fa-toggle_on' => in_array($item->id, $treatments_used),
                                            'nf-fa-toggle_off' => !in_array($item->id, $treatments_used),
                                        ])></i></button>
                            </td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#treatment-modal"
                                    wire:click="getTreatment({{ $item->id }})" @if($status == 1) disabled @endif><i class="fa fa-pen"></i></button>
                                <button wire:click="toggleFinished({{ $item->id }})" @class([
                                    'btn',
                                    'btn-success' => in_array($item->id, $finished),
                                    'btn-secondary' => !in_array($item->id, $finished),
                                ])
                                    @if ($item->status == 2 || $status == 1) disabled @endif><i
                                        class="nf nf-cod-check"></i></button>
                                <button wire:click="removeTreatment({{ $item->id }})" class="btn btn-danger" @if ($item->status == 2 || $item->histories()->count() > 0 || $status == 1) disabled @endif><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mb-3">
        <label for="">Piezas a Tratar</label>

        @foreach (array_chunk(range(1, 20), 4) as $row)
            <div class="row">
                @foreach ($row as $tooth)
                    <div class="col">
                        <i style="cursor: pointer;"   @if($status == 0) wire:click="toggleTooth('{{ $tooth }}')" @endif @class([
                            'nf',
                            'nf-md-tooth_outline',
                            'fs-3',
                            'cursor-pointer',
                            'text-primary' => in_array($tooth, $parts),
                            'text-black' => !in_array($tooth, $parts),
                        ])>
                            {{ $tooth }}
                        </i>
                    </div>
                @endforeach
            </div>
        @endforeach

        @php
            $age = \Carbon\Carbon::parse($patient->birthdate)->age;
        @endphp

        @if ($age > 3)
            @foreach (array_chunk(range(21, 32), 4) as $row)
                <div class="row">
                    @foreach ($row as $tooth)
                        <div class="col">
                            <i style="cursor: pointer;" @if($status == 0) wire:click="toggleTooth('{{ $tooth }}')" @endif @class([
                                'nf',
                                'nf-md-tooth_outline',
                                'fs-3',
                                'cursor-pointer',
                                'text-primary' => in_array($tooth, $parts),
                                'text-black' => !in_array($tooth, $parts),
                            ])>
                                {{ $tooth }}
                            </i>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col">
            <label for="">Diagnostico</label>
            <textarea wire:model="diagnostic" rows="3" cols="" class="form-control"
                placeholder="Ingrese Observación..." @if($status == 1) disabled @endif></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">

            <label for="">Prescripción</label>
            <textarea wire:model="prescription" rows="3" cols="" class="form-control"
                placeholder="Ingrese Prescripción..." @if($status == 1) disabled @endif></textarea>
        </div>
    </div>
    <h5 class="text-dark"><strong>Programar Citas</strong></h5>
    <div class="row mb-3">
        <div class="col">
            <label for="">Fecha</label>
            <input type="date" class="form-control" wire:model.live="date_reservation" @if($status == 1) disabled @endif>
        </div>
        <div class="col">
            <label for="">Horario</label>
            <div class="input-group">
                <select class="form-select" wire:model="schedule_reservation" @if($status == 1) disabled @endif>
                    <option value="">Selecione un Horario</option>
                    @foreach ($schedules ?? [] as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->start_time . ':00 - ' . $item->end_time . ':00' }}</option>
                    @endforeach
                </select>
                <button wire:click="addReservation" class="btn btn-primary" @if($status == 1) disabled @endif><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($reservations ?? [] as $item)
                        <tr>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->StaffSchedule->start_time . ':00 - ' . $item->StaffSchedule->end_time . ':00' }}
                            </td>
                            <td><button wire:click="removeReservation({{ $item->id }})" class="btn btn-danger" @if($status == 1) disabled @endif><i
                                        class="fa fa-trash"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <label for="">Saldo</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model="balance" disabled>
                <span class="input-group-text">Bs</span>
            </div>
        </div>
        <div class="col">
            <label for="">Cancelado</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model="price" placeholder="Ingrese Cancelado" @if($status == 1) disabled @endif>
                <span class="input-group-text">Bs</span>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-end">
        <button wire:click="save" class="btn btn-primary" @if($status == 1) disabled @endif>Guardar</button>
        <button wire:click="back" class="btn btn-secondary">Cancelar</button>
    </div>




    <x-modal id="treatment-modal" title="Tratamiento" class="">
        <div class="modal-body">
            <label for="">Tratamiento</label>
            <select class="form-select" wire:model="treatment_modal">
                <option value="">Seleccione Tratamiento</option>
                @foreach ($treatments_list as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <label for="">Descripción</label>
            <textarea wire:model="description_modal" rows="3" class="form-control" placeholder="Ingrese Descripción"></textarea>
            <label for="">Precio</label>
            <div class="input-group">
                <input type="text" class="form-control current" placeholder="Ingrese Precio"
                    wire:model="price_modal">
                <span class="input-group-text">Bs</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" wire:click="saveTreatment">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </x-modal>
</div>

@script
    <script>
        // document.addEventListener('keypress', (e) => {
        //     const current = e.target.closest('.current');
        //     if(current){



        // if((e.keyCode < 48 || e.keyCode > 57) && e.keyCode != 44){
        //     e.preventDefault()
        // }else{
        // const value = parseFloat(current.value.replace(',', '.'));
        // console.log(value, current.value)
        // if (!isNaN(value)) {
        //     e.target.value = formatter.format(value);
        // }
        // current.value = Intl.NumberFormat('es-BO',{
        //     style: 'decimal',
        //     minimumFractionDigits: 2,
        //     maximumFractionDigits: 2
        // }).format(value);
        // }
        //         }
        // });

        // document.addEventListener('keyup', (e) =>{
        //
        //     const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
        //
        //     console.log(allowedKeys.includes(e.key))
        //     if (!/^[0-9]$/.test(e.key) && allowedKeys.includes(e.key)) {
        //         e.preventDefault();
        //         console.log("a")
        //         return;
        //     }
        //
        // const value = parseFloat(e.target.value.replace(',', '.'));
        // console.log("blur : "+value);
        // console.log(!isNaN(value))
        //     if (!isNaN(value)) {
        //         e.target.value = Intl.NumberFormat('es-BO',{
        //             style: 'decimal',
        //             minimumFractionDigits: 2,
        //             maximumFractionDigits: 2
        //         }).format(value);
        //         console.log("format: "+e.target.value)
        //     }
        // });


        document.addEventListener('click', (e) => {

            const btnTooth = e.target.closest('.tooth');
            if (btnTooth) {
                const tooth = btnTooth.getAttribute('data-tooth');
                btnTooth.classList.toggle('text-primary');
                if ($wire.parts.indexOf(tooth) == -1)
                    $wire.parts.push(tooth);
                else $wire.parts.splice($wire.parts.indexOf(tooth), 1);
                console.log($wire.parts);
            }
        });
    </script>
@endscript
