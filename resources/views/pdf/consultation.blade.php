<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-top: 18px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 13px;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #444;
            padding: 6px;
        }

        .section-title {
            margin-top: 20px;
            margin-bottom: 8px;
            font-weight: bold;
            background-color: #f2f2f2;
            padding: 6px;
        }

        .no-border td {
            border: none;
            padding: 4px;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>

    <header>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/logo.jpg'))) }}"
             style="position: fixed;left: 10px;top:-20px; width: 120px;height: 88px;">
    </header>
    <!-- ENCABEZADO -->
    <div class="header">
        <div class="title">CONSULTA ODONTOLÓGICA</div>
        <div class="subtitle">Los Andes</div>
    </div>

    <!-- INFORMACIÓN GENERAL -->
    <table class="table-bordered">
        <tr>
            <th width="25%">Paciente</th>
            <td width="25%">{{ $history->patient->name }}</td>

            <th width="25%">Fecha</th>
            <td width="25%">{{ $history->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Médico</th>
            <td>{{ $history->reservation->StaffSchedule->staff->person->name }}</td>

            <th>N° Consulta</th>
            <td>#{{ $history->id }}</td>
        </tr>
    </table>

    <!-- MOTIVO -->
    <div class="section-title">Motivo de Consulta</div>
    <table class="table-bordered">
        <tr>
            <td>
                {{ $history->description ?? 'Sin descripción registrada.' }}
            </td>
        </tr>
    </table>

    <!-- DIAGNÓSTICO -->
    <div class="section-title">Diagnóstico</div>
    <table class="table-bordered">
        <tr>
            <td>
                {{ $history->diagnostic ?? 'Sin diagnóstico registrado.' }}
            </td>
        </tr>
    </table>

    <!-- TRATAMIENTOS -->
    <div class="section-title">Tratamientos Realizados</div>
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

    <!-- TOTAL -->
    <table class="no-border" style="margin-top:10px;">
        <tr>
            <td width="50%"></td>
            <td width="50%" class="text-right total">
                Total Cancelado: {{ number_format($history->amount, 2) }} Bs
            </td>
        </tr>
    </table>

    <!-- PRESCRIPCIÓN -->
    <div class="section-title">Prescripción Médica</div>
    <table class="table-bordered">
        <tr>
            <td>
                {{ $history->prescription ?? 'Sin prescripción registrada.' }}
            </td>
        </tr>
    </table>

    <!-- FIRMA -->
    <div style="margin-top:60px; text-align:center;">
        _______________________________<br>
        Firma y Sello del Profesional
    </div>

    <div class="footer">
        Documento generado automáticamente por el sistema clínico.
    </div>

</body>
</html>
