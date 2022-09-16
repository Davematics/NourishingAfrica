<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserRepository implements UserRepositoryInterface 
{
    public function update(object $userDetails) 
    {
        try {
        $user = User::where('id',auth()->user()->id)->first();
        $user->name = $userDetails->name;
        $user->phone_number = $userDetails->phone_number;
        $user->country = $userDetails->country;
        $user->save();

        return  $user;
        
        } catch (Exception $e) {
            
        return $e->getMessage();
        }
    }

    

   
}
