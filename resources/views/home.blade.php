@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="text-black">Reservaciones</h2>
            <button data-bs-toggle="modal" data-bs-target="#schedule-modal" class="btn btn-primary"><i
                                                                            class="nf nf-fa-plus"></i> Añadir Reserva</button>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <livewire:reservation-patient></livewire:reservation-patient>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
