<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $fillable = [
        'ci',
        'name',
        'birthdate',
        'gender',
        'phone',
        'ref_phone'
    ];

    public function users(){
        // return $this->hasOne(User::class);
        return $this->hasMany(User::class);
    }

    protected function name(): Attribute{
        return Attribute::make(
            get: fn(string $value) => ucwords($value)
        );
    }

    public function histories(){
        return $this->hasMany(History::class);
    }
}
