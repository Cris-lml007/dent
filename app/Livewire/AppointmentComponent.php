<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\History;
use App\Models\HistoryTreatment;
use App\Models\PeopleTreatment;
use App\Models\Person;
use App\Models\Reservation;
use App\Models\StaffSchedule;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppointmentComponent extends Component
{

    public Reservation $reservation;


    public $parts = [];

    public $treatments = [];
    public $treatments_used = [];

    public $toohts;
    public $description;
    public $diagnostic;
    public $prescription;
    public $balance = 0;
    public $price;

    public $id_modal;
    public $treatment_modal;
    public $price_modal;
    public $description_modal;

    public $schedules;
    public $date_reservation;
    public $schedule_reservation;
    public $reservations;

    public $finished = [];

    public $status = 0;



    public function toggleTooth($tooth){
        if (in_array($tooth, $this->parts)) {
            $this->parts = array_values(array_diff($this->parts, [$tooth]));
        } else {
            $this->parts[] = $tooth;
        }
    }

    public function getTreatment($id){
        $treatment = PeopleTreatment::find($id);
        $this->id_modal = $id;
        $this->treatment_modal = $id;
        $this->price_modal = $treatment->price;
        $this->description_modal = $treatment->description;
    }

    public function saveTreatment(){
        if($this->id_modal == null)
            $treatment = new PeopleTreatment();
        else
            $treatment = PeopleTreatment::find($this->id_modal);

        $treatment->description = $this->description_modal;
        $treatment->price = $this->price_modal;
        $treatment->treatment_id = $this->treatment_modal;
        $treatment->person_id = $this->reservation->patient->id;
        $treatment->user_id = Auth::user()->id;
        $treatment->status = 1;
        $treatment->save();
    }

    public function removeTreatment($id){
        PeopleTreatment::destroy($id);
    }


    public function updatedDateReservation(){
        $this->schedules = [];
        if($this->date_reservation != null){
            $day = Carbon::parse($this->date_reservation)->dayOfWeek;
            $this->schedules = StaffSchedule::where('user_id',Auth::user()->id)
                 ->where('day',$day)
                 ->whereDoesntHave('reservations',function(Builder $builder){
                     $builder->where('date',$this->date_reservation);
                 })
                 ->get();

        }else{
            $this->schedules = [];
        }
    }

    public function toggleTreatment($id){
        $key = array_search($id,$this->treatments_used);
        if($key !== false){
            unset($this->treatments_used[$key]);
            // $this->balance -= PeopleTreatment::find($id)->price;
        }else{
            $this->treatments_used[] = $id;
            // $this->balance += PeopleTreatment::find($id)->price;
        }
    }

    public function toggleFinished($id){
        $key = array_search($id,$this->finished);
        if($key !== false){
            unset($this->finished[$key]);
        }else{
            $this->finished[] = $id;
        }
    }


    public function addReservation(){
        $reservation = new Reservation();
        $reservation->date = $this->date_reservation;
        $reservation->person_id = $this->reservation->person_id;
        $reservation->staff_schedule_id = $this->schedule_reservation;
        $reservation->save();
    }

    public function removeReservation($id){
        Reservation::destroy($id);
    }

    public function mount(Reservation $reservation){
        $this->reservation = $reservation;
        $payment = History::where('person_id',$this->reservation->person_id)
            ->whereHas('treatments',function(Builder $builder){
                $builder->where('user_id',Auth::user()->id);
            })->sum('amount');
        $t = PeopleTreatment::where('person_id',$this->reservation->person_id)
            ->where('user_id',Auth::user()->id)
            ->sum('price');
        $this->balance += $t;
        $this->balance -= $payment;

        if($this->reservation->history()->count() > 0){
            $history = $this->reservation->history;
            $this->description = $history->description;
            $this->prescription = $history->prescription;
            $this->diagnostic = $history->diagnostic;
            $this->parts = explode(',',$history->parts);
            $this->price = $history->amount;
            foreach(HistoryTreatment::where('history_id',$history->id)->get() as $item){
                $this->treatments_used [] = $item->id;
            }
            $this->status = 1;
        }
    }

    public function save(){
        $history = new History();
        $history->description = $this->description;
        $history->diagnostic = $this->diagnostic;
        $history->prescription = $this->prescription;
        $history->amount = $this->price;
        $history->parts = implode(',',$this->parts);
        $history->person_id = $this->reservation->person_id;
        $history->reservation_id = $this->reservation->id;
        $history->save();

        foreach($this->treatments_used as $item){
            HistoryTreatment::create([
                'history_id' => $history->id,
                'people_treatment_id' => $item
            ]);

        }

        foreach( $this->finished as $item ){
            PeopleTreatment::where('id',$item)->update(['status'=> Status::FINISHED]);
        }
        return $this->redirect(route('administration.dashboard'));
    }

    public function back(){
        return redirect()->route('administration.dashboard');
    }


    public function render()
    {
        $patient = $this->reservation->patient;
        $heads = ['ID','Nombre'];
        $treatments_list = Treatment::all();
        $this->reservations = Reservation::where('date','>=',Carbon::now())
             ->where('person_id',$this->reservation->patient->id)
             ->whereHas('StaffSchedule',function(Builder $builder){
                 $builder->where('user_id',Auth::user()->id);
             })->get();
        $this->treatments = PeopleTreatment::where('person_id',$this->reservation->patient->id)
             ->where('user_id',Auth::user()->id)
             ->get();
        return view('livewire.appointment-component', compact(['heads','patient','treatments_list']));
    }
}
