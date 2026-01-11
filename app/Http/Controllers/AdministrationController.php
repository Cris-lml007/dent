<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdministrationController extends Controller
{
    public function index(){
        $heads = ['ID', 'Horario','Paciente', 'Medico', 'Especialidad'];
        $data = [];
        return view('administration.dashboard',compact(['heads', 'data']));
    }

    public function scheduleMedic() {
        $heads = ['ID', 'Fecha',' Horario', 'Paciente', 'Medico', 'Especialidad', ' Opciones'];
        $data = [
            [1, '2024-07-01', '13:00', 'Juan Perez', 'Dr. Smith', 'Cardiologia'],
            [2, '2024-07-02', '14:00', 'Maria Lopez', 'Dra. Garcia', 'Dermatologia'],
            [3, '2024-07-03', '15:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '16:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '17:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '18:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '19:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '20:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '21:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
            [3, '2024-07-03', '22:00', 'Carlos Sanchez', 'Dr. Johnson', 'Neurologia'],
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
        $heads = ['CI', 'Nombre', 'Edad', 'Telefono', 'Opciones'];
        $data = Person::all();
        return view('administration.patients', compact(['heads', 'data']));
    }

    public function staff(){
        // dd(User::all());
        $heads = ['CI', 'Nombre Completo', 'Rol', 'Telefono', 'Estado','Opciones'];
        $specialtyHeads = ['ID', 'Nombre', 'Opciones'];
        $data = Person::whereHas('users',function (Builder $query){
            $query->where('role','!=',Role::PATIENT);
        })->get();
        return view('administration.staff', compact(['heads','data','specialtyHeads']));
    }

    public function settings(){
        $headSpecialty = ['ID','Nombre', 'Descripción'];
        return view('administration.settings', compact(['headSpecialty']));
    }
}
