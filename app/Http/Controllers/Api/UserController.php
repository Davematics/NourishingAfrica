<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }
    public function UpdateUser(UpdateUserRequest $request)
    {
        $update = $this->userRepository->update($request);

        return $this->success('User Updated Successfully', $update, Response::HTTP_CREATED);
    }
}