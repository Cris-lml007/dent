@extends('layouts.main')
@section('header')
    <h1>Reportes</h1>
@endsection

@section('content')
    <!-- 🔍 Filtro por fechas -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label>Fecha inicio</label>
                    <input type="date" name="start_date" value="{{ $start }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Fecha fin</label>
                    <input type="date" name="end_date" value="{{ $end }}" class="form-control">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 📊 KPI Cards -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Ingresos</h6>
                    <h3>{{ number_format($totalIncome, 2) }} Bs</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Citas</h6>
                    <h3>{{ $totalReservations }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Pacientes Nuevos</h6>
                    <h3>{{ $newPatients }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>% Cancelación</h6>
                    <h3>{{ $cancellationRate }}%</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- 📈 Gráfico ingresos -->
    <div class="card">
        <div class="card-body">
            <div style="height:350px;">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5>Citas últimos 7 días</h5>
                    <canvas id="reservationChart"></canvas>
                </div>
                <div class="col-md-6 mb-4">
                    <h5>Tratamientos más realizados</h5>
                    <div class="chart-container d-flex justify-content-center">
                        <canvas id="treatmentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            new Chart(document.getElementById('incomeChart'), {
                type: 'bar',
                data: {
                    labels: @json($incomeLabels),
                    datasets: [{
                        label: 'Ingresos',
                        data: @json($incomeValues),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            new Chart(document.getElementById('treatmentChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($treatmentLabels),
                    datasets: [{
                        data: @json($treatmentValues)
                    }]
                }
            });


            new Chart(document.getElementById('reservationChart'), {
                type: 'line',
                data: {
                    labels: @json($reservationLabels),
                    datasets: [{
                        label: 'Citas',
                        data: @json($reservationValues),
                        fill: false
                    }]
                }
            });

        });
    </script>























    <style>
        .chart-container {
            position: relative;
            height: 350px;
        }
    </style>
    {{--     <div class="card"> --}}
    {{--         <div class="card-body"> --}}
    {{--             <div class="row"> --}}
    {{-- --}}
    {{--                 <!-- Ingresos --> --}}
    {{--                 <div class="col-md-6 mb-4"> --}}
    {{--                     <h5>Ingresos por mes</h5> --}}
    {{--                     <canvas id="incomeChart"></canvas> --}}
    {{--                 </div> --}}
    {{-- --}}
    {{--                 <!-- Tratamientos --> --}}
    {{--                 <div class="col-md-6 mb-4"> --}}
    {{--                     <h5>Tratamientos más realizados</h5> --}}
    {{--                     <!-- <canvas id="treatmentChart"></canvas> --> --}}
    {{--                     <div class="chart-container d-flex justify-content-center"> --}}
    {{--                         <canvas id="treatmentChart"></canvas> --}}
    {{--                     </div> --}}
    {{--                 </div> --}}
    {{-- --}}
    {{--                 <!-- Citas --> --}}
    {{--                 <div class="col-md-6 mb-4"> --}}
    {{--                     <h5>Citas últimos 7 días</h5> --}}
    {{--                     <canvas id="reservationChart"></canvas> --}}
    {{--                 </div> --}}
    {{-- --}}
    {{--                 <!-- Pacientes --> --}}
    {{--                 <div class="col-md-6 mb-4"> --}}
    {{--                     <h5>Pacientes nuevos por mes</h5> --}}
    {{--                     <canvas id="patientChart"></canvas> --}}
    {{--                 </div> --}}
    {{-- --}}
    {{--             </div> --}}
    {{-- --}}
    {{-- --}}
    {{--         </div> --}}
    {{--     </div> --}}
    {{-- @endsection --}}
    {{-- --}}
    {{-- @section('js') --}}
    {{--     <script> --}}
    {{--         document.addEventListener('DOMContentLoaded', () => { --}}
    {{--             // 📈 Ingresos --}}
    {{--             new Chart(document.getElementById('incomeChart'), { --}}
    {{--                 type: 'bar', --}}
    {{--                 data: { --}}
    {{--                     labels: @json($incomeLabels), --}}
    {{--                     datasets: [{ --}}
    {{--                         label: 'Ingresos', --}}
    {{--                         data: @json($incomeValues), --}}
    {{--                         borderWidth: 1 --}}
    {{--                     }] --}}
    {{--                 } --}}
    {{--             }); --}}
    {{-- --}}
    {{--             // 🦷 Tratamientos --}}
    {{--             new Chart(document.getElementById('treatmentChart'), { --}}
    {{--                 type: 'doughnut', --}}
    {{--                 data: { --}}
    {{--                     labels: @json($treatmentLabels), --}}
    {{--                     datasets: [{ --}}
    {{--                         data: @json($treatmentValues) --}}
    {{--                     }] --}}
    {{--                 } --}}
    {{--             }); --}}
    {{-- --}}
    {{--             // 📅 Citas --}}
    {{--             new Chart(document.getElementById('reservationChart'), { --}}
    {{--                 type: 'line', --}}
    {{--                 data: { --}}
    {{--                     labels: @json($reservationLabels), --}}
    {{--                     datasets: [{ --}}
    {{--                         label: 'Citas', --}}
    {{--                         data: @json($reservationValues), --}}
    {{--                         fill: false --}}
    {{--                     }] --}}
    {{--                 } --}}
    {{--             }); --}}
    {{-- --}}
    {{--             // 👥 Pacientes --}}
    {{--             new Chart(document.getElementById('patientChart'), { --}}
    {{--                 type: 'bar', --}}
    {{--                 data: { --}}
    {{--                     labels: @json($patientLabels), --}}
    {{--                     datasets: [{ --}}
    {{--                         label: 'Pacientes nuevos', --}}
    {{--                         data: @json($patientValues) --}}
    {{--                     }] --}}
    {{--                 } --}}
    {{--             }); --}}
    {{-- --}}
    {{--         }); --}}
    {{--     </script> --}}
@endsection
