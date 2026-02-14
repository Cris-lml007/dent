<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Person;
use App\Models\Reservation;
use App\Models\Specialty;
use App\Models\StaffSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class ScheduleComponent extends Component
{

    public $ci;
    public $name;
    public $gender;
    public $birthdate;
    public $phone;
    public $ref_phone;
    public $email;
    public $active;
    public $medic;
    public $specialty;
    public $date;
    public $schedule;

    public $patient_id;

    // public $specialties_list;
    public $medics_list;
    public $schedules_list;

    public function updatedCi(){
        $patient = Person::where('ci',$this->ci)->first();
        if($patient){
            $this->name = $patient->name;
            $this->gender = $patient->gender;
            $this->birthdate = $patient->birthdate;
            $this->phone = $patient->phone;
            $this->ref_phone = $patient->ref_phone;
            $u = $patient->users()->where('role',Role::PATIENT)->first();
            $this->email = $u->email;
            $this->active = $u->active;

            $this->patient_id = $patient->id;
        }else{
            $this->name = null;
            $this->gender = null;
            $this->birthdate = null;
            $this->phone = null;
            $this->ref_phone = null;
            $this->email = null;
            $this->active = null;

            $this->patient_id = null;
        }
    }

    public function updatedSpecialty(){
        if($this->specialty != null){
            $this->medics_list = User::whereHas('specialties',function(Builder $builder){
                $builder->where('specialty_id',$this->specialty);
            })->get();
        }else{
            $this->medics_list = User::where('role',Role::MEDIC)->get();
        }
    }

    public function updatedMedic(){
        $this->schedules_list = [];
        $this->updatedDate();
        // $this->specialties_list = User::find($this->medic)?->specialties ?? [];
        // dd($this->specialties_list);
    }

    public function updatedDate(){
        $this->schedules_list = [];
        if($this->date != null){
            $day = Carbon::parse($this->date)->dayOfWeek;
            $this->schedules_list = StaffSchedule::where('user_id',$this->medic)
                 ->where('day',$day)
                 ->whereDoesntHave('reservations',function(Builder $builder){
                     $builder->where('date',$this->date);
                 })
                 ->get();

        }else{
            $this->schedules_list = [];
        }
    }

    public function save(){

        if($this->patient_id == null){
            $patient = new Person();
            $patient->ci = $this->ci;
            $patient->name = $this->name;
            $patient->birthdate = $this->birthdate;
            $patient->gender = $this->gender;
            $patient->phone = $this->phone;
            $patient->ref_phone = $this->ref_phone;
            $patient->save();
            $this->patient_id = $patient->id;

            $user = new User();

            if($this->email != null){
                $user->email = $this->email;
                $user->role = Role::PATIENT;
                $user->active = $this->active;
                $user->person_id = $this->patient->id;
                $user->password = Str::random(8);
                $user->save();
            }
        }

        Reservation::create([
            'person_id' => $this->patient_id,
            'staff_schedule_id' => $this->schedule,
            'date' => $this->date
        ]);
        redirect()->route('administration.schedule-medic');
    }

    public function mount(){
        $this->medics_list = User::where('role',Role::MEDIC)->get();
    }

    public function render()
    {
        $specialties_list = Specialty::all();

        $userLogin = Auth::user();
        return view('livewire.schedule-component',compact(['userLogin','specialties_list']));
    }
}
