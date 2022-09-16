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
use Illuminate\Http\JsonResponse;
use App\Interfaces\AuthRepositoryInterface;
class AuthController extends Controller
{
    
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository) 
    {
        $this->authRepository = $authRepository;
    }


    public function UserRegistration(RegistrationRequest $request)  
    {

       $user = $this->authRepository->userRegistration($request);

        return $this->success('User created successfully', $user, Response::HTTP_CREATED);
    }


   
    public function login(LoginRequest $request)
    {
        
        $login = $this->authRepository->login($request);
       
        return $this->success('User login successfully', $login, Response::HTTP_OK);
    }


    public function logout(Request $request)
    {
      
        $logout = $this->authRepository->logout();
       
        return $this->success('User logout successfully', $logout, Response::HTTP_OK);
    
    }
}
