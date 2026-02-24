<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(Request $request)
    {
        if($request->user()->active == 0){
            $request->session()->flush();
        }
        // dd($request->user()->role);
        //
    }

    public function isNotReception(User $user){
        return $user->role != Role::RECEPTION && $user->role != Role::PATIENT;
    }

    public function isAdministration(User $user){
        return $user->role != Role::PATIENT;
    }

    public function isMedic(User $user){
        return $user->role == Role::MEDIC;
    }

    public function isPatient(User $user){
        return $user->role == Role::PATIENT;
    }

    public function isAdmin(User $user){
        return $user->role == Role::ADMIN;
    }

    public function isReceptionist(User $user){
        return $user->role == Role::RECEPTION;
    }

    public function isNotRoot(User $user){
        return $user->person_id != null;
    }
}
