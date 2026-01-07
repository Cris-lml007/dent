<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Person;
use App\Models\Specialty;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StaffComponent extends Component
{

    public $ci;
    public $name;
    public $birthdate;
    public $gender;
    public $phone;
    public $ref_phone;

    public $email;
    public $password;
    public $role;
    #[Validate('required')]
    public $status;

    public Person $person;

    public $specialty;
    public $specialties_list = [];

    public $schedules_list;
    public $start_time;
    public $end_time;
    public $day;

    public function mount(Person $person = null){
        if($person->exists){
            $this->ci = $person->ci;
            $this->name = $person->name;
            $this->birthdate = $person->birthdate;
            $this->phone = $person->phone;
            $this->ref_phone = $person->ref_phone;
            $this->gender = $person->gender;

            $this->email = $person->user->email;
            $this->role = $person->user->role;
            $this->status = $person->user->active;
            $this->specialties_list = $person->user->specialties->map(function($specialty){
                return [
                    'id' => $specialty->id,
                    'name' => $specialty->name
                ];
            })->toArray();

            $this->schedules_list = $person->user->staffSchedules->map(function($schedule){
                return [
                    'id' => $schedule->id,
                    'day' => $schedule->day,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'active' => $schedule->active
                ];
            })->toArray();
            $this->person = $person;
        }else{
            $this->person = new Person();
        }
    }

    public function getStaff(Person $person = null){
        if($person != null){
            $this->person = $person;
            $this->ci = $person->ci;
            $this->name = $person->name;
            $this->birthdate = $person->birthdate;
            $this->gender = $person->gender;
            $this->phone = $person->phone;
            $this->ref_phone = $person->ref_phone;
            $this->email = $person->email;
            $this->role = $person->role;
            $this->status = $person->status;
        }else{
            $this->person = new Person();
        }
    }

    public function addSpecialty(){
        if($this->specialty == null) return;
        foreach($this->specialties_list as $specialty){
            if($specialty['id'] == $this->specialty){
                return;
            }
        }
        $this->specialties_list[] = [
            'id' => $this->specialty,
            'name' => Specialty::find($this->specialty)->name
        ];
    }

    public function removeSpecialty($id){
        foreach($this->specialties_list as $key => $specialty){
            if($specialty['id'] == $id){
                $index = $key;
            }
        }
        unset($this->specialties_list[$index]);
    }

    public function addSchedule(){
        if ((int)$this->end_time <= (int)$this->start_time) return;
        foreach($this->schedules_list as $schedule){
            if( $schedule['day'] == $this->day &&
                $schedule['start_time'] >= $this->start_time &&
                $schedule['end_time'] <= $this->end_time && $schedule['active'] == 1){
                return;
            }
        }

        $this->schedules_list[] = [
            'id' => null,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'active' => 1
        ];
    }

    public function removeSchedule($index){
        if($this->schedules_list[$index]['id'] != null){
            $this->schedules_list[$index]['active'] = 0;
        }else{
            unset($this->schedules_list[$index]);
        }
    }

    public function saveStaff(){
        // dd($this->person);
        $this->validate([
            'ci' => 'required|integer|unique:people,ci,'.$this->person->id,
            'name' => 'required|string',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'phone' => 'required|integer',
            'email' => 'required|email|unique:users,email,'. $this->person->user->id ?? '0',
            'role' => 'required',
            'status' => 'required'
        ]);
        if( $this->person == null ){
            $this->person = new Person();
        }
        $this->person->ci = $this->ci;
        $this->person->name = $this->name;
        $this->person->birthdate = $this->birthdate;
        $this->person->gender = $this->gender;
        $this->person->phone = $this->phone;
        $this->person->ref_phone = $this->ref_phone;
        $this->person->save();


        $user = $this->person->user;
        if($user == null) $user = new User();
        $user->email = $this->email;
        $user->role = $this->role;
        $user->active = $this->status;
        if( !$user->exists() || $this->password != null)
            $user->password = $this->password;
        $user->person_id = $this->person->id;
        $user->save();


        $user->specialties()->detach();
        foreach($this->specialties_list as $specialty){
            $user->specialties()->attach($specialty['id']);
        }

        foreach($this->schedules_list as $schedule){
            $user->staffSchedules()->updateOrCreate([
                'id' => $schedule['id']
            ],[
                'day' => $schedule['day'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'active' => $schedule['active'],
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('administration.staff');
    }


    #[Title('Personal')]
    public function render()
    {
        $specialties = Specialty::all();
        $roles = Role::cases();
        return view('livewire.staff-component', compact('specialties','roles'));
    }
}
