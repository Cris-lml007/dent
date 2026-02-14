<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    public function patient(){
        return $this->belongsTo(Person::class,'person_id','id');
    }

    public function treatments(){
        return $this->belongsToMany(PeopleTreatment::class,'history_treatments','history_id','people_treatment_id');
    }

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
