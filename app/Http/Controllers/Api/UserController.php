<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    
    public function UpdateUser(UpdateUserRequest $request)
    {

        $user = User::where('id',auth()->user()->id)->first();
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->country = $request->country;
        $user->save();

        return $this->success('User Updated Successfully', $user, Response::HTTP_CREATED);
    }
}