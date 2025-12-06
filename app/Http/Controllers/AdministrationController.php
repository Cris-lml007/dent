<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrationController extends Controller
{
    public function index(){
        return view('administration.dashboard');
    }

    public function scheduleMedic() {
        $heads = ['ID', 'Fecha', 'Paciente', 'Medico', 'Especialidad', ' Opciones'];
        $data = [
            [1, '2024-07-01', 'Juan Perez', 'Dr. Smith', 'Cardiologia'],
            [2, '2024-07-02', 'Maria Lopez', 'Dra. Garcia', 'Dermatologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
        ];
        return view('administration.schedule-medic',compact(['heads','data']));
    }

    public function historyMedic() {
        $heads = ['ID', ' Fecha', 'Paciente', 'Medico', ' Especialidad', 'Opciones'];
        $data = [
            [1, '2024-07-01', 'Juan Perez', 'Dr. Smith', 'Cardiologia'],
            [2, '2024-07-02', 'Maria Lopez', 'Dra. Garcia', 'Dermatologia'],
            [3, '2024-07-03', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
        ];
        return view('administration.history-medic', compact(['heads', 'data']));
    }

    public function patients(){
        $heads = ['CI', 'Nombre', 'Telefono', 'Opciones'];
        $data = [
            ['12345678', 'Juan Perez', '555-1234'],
            ['87654321', 'Maria Lopez', '555-5678'],
            ['11223344', 'Carlos Sanchez', '555-8765'],
        ];
        return view('administration.patients', compact(['heads', 'data']));
    }

    public function staff(){
        $heads = ['CI', 'Nombre', 'Especialidad', 'Rol', 'Telefono', 'Opciones'];
        $specialtyHeads = ['ID', 'Nombre', 'Opciones'];
        $data = [];
        return view('administration.staff', compact(['heads','data','specialtyHeads']));
    }
}
