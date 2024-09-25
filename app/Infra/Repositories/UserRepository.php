<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\IUserRepository;
use App\Domain\Entities\User;
use App\Infra\Repositories\DataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository extends DataRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function login(Request $request){
        dd("oi");
    }
    public function signIn(Request $request){
    
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        
        $user = $this->create($data);
        
        return response()->json(['message' => 'User registered successfully.'], 201);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}