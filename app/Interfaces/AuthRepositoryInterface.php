<?php
namespace App\Interfaces;

interface AuthRepositoryInterface 
{

    public function userRegistration(object $userDetails);
    public function login(object $userDetails);
    public function logout();
}