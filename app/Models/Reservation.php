<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public $fillable = [
        'person_id',
        'staff_schedule_id',
        'date'
    ];

    public function patient(){
        return $this->belongsTo(Person::class,'person_id','id');
    }

    public function StaffSchedule(){
        return $this->belongsTo(StaffSchedule::class);
    }

    public function history(){
        return $this->hasOne(History::class);
    }
}
