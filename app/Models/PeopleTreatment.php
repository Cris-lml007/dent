<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleTreatment extends Model
{
    public function treatment(){
        return $this->belongsTo(Treatment::class);
    }

    public function histories(){
        return $this->belongsToMany(History::class,'history_treatments');
    }
}
