<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Person;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class PatientComponent extends Component
{
    public $ci;
    public $name;
    public $gender;
    public $birthdate;
    public $phone;
    public $ref_phone;
    public $email;
    public $active;

    public Person $patient;

    public function mount(Person $person = null){
        if($person->id != null && $person->user->role == Role::PATIENT){
            $this->ci = $person->ci;
            $this->name = $person->name;
            $this->gender = $person->gender;
            $this->birthdate = $person->birthdate;
            $this->phone = $person->phone;
            $this->ref_phone = $person->ref_phone;
            $this->email = $person->user->email;
            $this->active = $person->user->active;

            $this->patient = $person;
        }else{
            $this->patient = new Person();
        }

    }

    public function removePatient(){
        $this->patient->delete();
        return redirect()->route('administration.patients');
    }

    public function savePatient(){
        $this->validate([
            'ci' => 'required|unique:people,ci,'.$this->patient->id,
            'name' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'active' => 'required'
        ]);
        if($this->patient->id == null){
            $this->patient = new Person();
            $user = new User();
        }else{
            $user = $this->patient->user;
            if($user == null){
                $user = new user();
            }
        }
        $this->patient->ci = $this->ci;
        $this->patient->name = $this->name;
        $this->patient->birthdate = $this->birthdate;
        $this->patient->gender = $this->gender;
        $this->patient->phone = $this->phone;
        $this->patient->ref_phone = $this->ref_phone;
        $this->patient->save();

        $user->email = $this->email;
        $user->role = Role::PATIENT;
        $user->active = $this->active;
        $user->person_id = $this->patient->id;
        $user->password = Str::random(8);
        $user->save();

        return redirect()->route('administration.patients');
    }

    #[Title('Paciente')]
    public function render()
    {
        return view('livewire.patient-component');
    }
}
