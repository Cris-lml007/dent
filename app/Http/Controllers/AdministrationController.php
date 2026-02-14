<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Person;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AdministrationController extends Controller
{
    public function index(){
        $heads = ['ID', 'Horario','Paciente', 'Medico', 'Especialidad'];
        $data = [];
        return view('administration.dashboard',compact(['heads', 'data']));
    }

    public function scheduleMedic() {
        $heads = ['ID', 'Fecha',' Horario', 'Paciente', 'Medico', ' Opciones'];
        if(Auth::user()?->role == Role::MEDIC){
            $is_medic = true;
            $data = Reservation::whereHas('StaffSchedule',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->where('date','>=',Carbon::now())->orderBy('date','desc')->get();
        }else{
            $is_medic = false;
            $data = Reservation::orderBy('date','desc')->get();
        }
        return view('administration.schedule-medic',compact(['heads','data','is_medic']));
    }

    public function removeSchedule($id){
        Reservation::destroy($id);
        return redirect()->back();
    }

    public function historyMedic() {
        $heads = ['ID', ' Fecha', 'Paciente', 'Medico', ' Especialidad', 'Opciones'];
        $data = Reservation::whereHas('StaffSchedule',function(Builder $builder){
            $builder->where('user_id',Auth::user()->id);
        })->whereHas('history',function(Builder $builder){
            $builder->where('id','!=',null);
        })->orderBy('date','desc')->get();
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
