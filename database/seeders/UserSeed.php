<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Person::factory(1)->create();
        // User::factory(10)->has(Person::factory())->create();
        Person::factory(10)->has(User::factory())->create();
    }
}
