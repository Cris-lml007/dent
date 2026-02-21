<?php

namespace App\Livewire;

use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class ReservationPatient extends Component
{

    public function remove($id){
        Reservation::destroy($id);
    }

    public function render()
    {
        $data = Reservation::whereDate('date','>=',Carbon::today())->get();
        return view('livewire.reservation-patient',compact('data'));
    }
}
