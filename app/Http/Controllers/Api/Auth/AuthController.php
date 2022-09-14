<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    
    public function UserRegistration(RegistrationRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->country = $request->country;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->success('User Created Successfully', $user, Response::HTTP_CREATED);
    }


   
    public function login(LoginRequest $request)
    {
        
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
          
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->failure('Invalid login details', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
           
            if (!Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
                return $this->failure('Invalid username and password details', Response::HTTP_UNPROCESSABLE_ENTITY);
            };
        }
       
        $user =  auth()->user();
        
        
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->access_token = $token;
       
        return $this->success('User login successfully', $user);
    }


    public function logout(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
       auth()->user()->tokens()->delete();

        return $this->success('logout was successful', Response::HTTP_OK);
    
    }
}
