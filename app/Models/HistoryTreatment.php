<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTreatment extends Model
{
    public $fillable = [
        'history_id',
        'people_treatment_id'
    ];
}
