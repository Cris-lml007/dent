<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseFactory(PersonFactory::class)]
class Person extends Model
{
    use HasFactory;

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

    public static function newFactory(){
        return PersonFactory::new();
    }
}
