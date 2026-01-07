<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    public $fillable = [
        'user_id',
        'day',
        'start_time',
        'end_time',
        'active'
    ];

    public function staff(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
