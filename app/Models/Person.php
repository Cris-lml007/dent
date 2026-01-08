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

    public function user(){
        return $this->hasOne(User::class);
    }

    protected function name(): Attribute{
        return Attribute::make(
            get: fn(string $value) => ucwords($value)
        );
    }
}
