<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            color: #333;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #444;
            padding: 5px;
        }

        .section-title {
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
            background-color: #f2f2f2;
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <table style="margin-bottom:20px;">
        <tr>
            <td style="width:25%;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/logo.jpg'))) }}"
                    style="width:90px;">
            </td>

            <td style="width:50%; text-align:center;">
                <div class="title">HISTORIAL MÉDICO ODONTOLÓGICO</div>
                <div class="subtitle">Clínica Dental Los Andes</div>
            </td>

            <td style="width:25%;"></td>
        </tr>
    </table>

    <hr>

    <!-- DATOS DEL PACIENTE -->
    <div class="section-title">Datos del Paciente</div>
    <table class="table-bordered">
        <tr>
            <th width="25%">Nombre</th>
            <td width="25%">{{ $person->name }}</td>

            <th width="25%">Identificación</th>
            <td width="25%">{{ $person->ci ?? '-' }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $person->phone ?? '-' }}</td>

            <th>Email</th>
            <td>{{ $person->users()->where('role', 3)->first()->email ?? '-' }}</td>
        </tr>
    </table>

    <!-- CONSULTAS -->
    @foreach ($person->histories as $history)
        <div class="section-title">
            Consulta #{{ $history->id }} - {{ $history->created_at->format('d/m/Y') }}
        </div>

        <table class="table-bordered">
            <tr>
                <th width="20%">Médico</th>
                <td width="80%">
                    {{ $history->reservation->StaffSchedule->staff->person->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>Motivo</th>
                <td>{{ $history->description ?? '-' }}</td>
            </tr>
            <tr>
                <th>Diagnóstico</th>
                <td>{{ $history->diagnostic ?? '-' }}</td>
            </tr>
            <tr>
                <th>Prescripción</th>
                <td>{{ $history->prescription ?? '-' }}</td>
            </tr>
        </table>

        <!-- Tratamientos -->
        <div class="section-title">Tratamientos</div>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th width="70%">Tratamiento</th>
                    <th width="30%" class="text-right">Costo (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history->treatments as $t)
                    <tr>
                        <td>{{ $t->treatment->name }}</td>
                        <td class="text-right">{{ number_format($t->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table style="margin-top:5px;">
            <tr>
                <td width="70%"></td>
                <td width="30%" class="text-right">
                    <strong>Total Consulta: {{ number_format($history->amount, 2) }} Bs</strong>
                </td>
            </tr>
        </table>
    @endforeach

    <hr style="margin-top:20px;">

    <div class="section-title">Resumen Financiero</div>

    <table class="table-bordered">
        <tr>
            <th width="50%">Total Tratamientos Realizados</th>
            <td width="50%" class="text-right">
                {{ number_format($totalTratamientos, 2) }} Bs
            </td>
        </tr>

        <tr>
            <th>Total Pagado</th>
            <td class="text-right">
                {{ number_format($totalPagado, 2) }} Bs
            </td>
        </tr>

        <tr>
            <th>Saldo Pendiente</th>
            <td class="text-right">
                {{ number_format($totalPendiente, 2) }} Bs
            </td>
        </tr>

        <tr>
            <th>Estado</th>
            <td class="text-right">
                @if ($totalPendiente > 0)
                    <strong style="color:red;">CON SALDO PENDIENTE</strong>
                @else
                    <strong style="color:green;">CUENTA AL DÍA</strong>
                @endif
            </td>
        </tr>
    </table>






    <div class="footer">
        Documento generado automáticamente por el sistema clínico.
    </div>

</body>
</html>
