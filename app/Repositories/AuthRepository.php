<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthRepository implements AuthRepositoryInterface 
{
    public function userRegistration(object $userDetails) 
    {
        try {
        $user = new User();
        $user->name = $userDetails->name;
        $user->phone_number = $userDetails->phone_number;
        $user->country = $userDetails->country;
        $user->email = $userDetails->email;
        $user->password = Hash::make($userDetails->password);
        $user->save();
        
        return  $user;

         } catch (Exception $e) {
            
            return $e->getMessage();
         }

    }

    public function login(object $userDetails) 
    {
        if (!Auth::attempt($userDetails->only('email', 'password'))) {

            return false;
        }
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->access_token = $token;

        return $user;
    }

    public function logout() 
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->tokens()->delete();

        return $user;
    }

   
}
