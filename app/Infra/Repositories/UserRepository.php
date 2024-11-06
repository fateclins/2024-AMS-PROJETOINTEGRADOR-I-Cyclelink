<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\IUserRepository;
use App\Domain\Entities\User;
use App\Infra\Mail\PasswordResetVerificationCode;
use App\Infra\Repositories\DataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserRepository extends DataRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }


        $token = $user->createToken('API Token')->plainTextToken;
        
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user, 
        ], 200);
    }
    public function signIn(Request $request){

        $data = $request->all();
        $user = $this->create($data);
        
        return response()->json(['message' => 'User registered successfully.'], 201);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }


    public function sendEmail(Request $request){
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        $allCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        do {
            $verificationCode = '';
            $verificationCode .= $uppercase[random_int(0, strlen($uppercase) - 1)];
            $verificationCode .= $numbers[random_int(0, strlen($numbers) - 1)];
            $verificationCode .= $symbols[random_int(0, strlen($symbols) - 1)];
    
            for ($i = 3; $i < 7; $i++) {
                $verificationCode .= $allCharacters[random_int(0, strlen($allCharacters) - 1)];
            }
    
            $verificationCode = str_shuffle($verificationCode);
    
            $existingCode = User::where('verification_token', $verificationCode)->first();
        } while ($existingCode);
    
        $user->verification_token = $verificationCode;
        $user->save();
    
        Mail::to($user->email)->send(new PasswordResetVerificationCode($verificationCode, $user));
    
        return response()->json(['message' => 'A verification code has been sent to your email.']);
    }
    

    public function resetPassword(Request $request)
    {   
        $user = User::where('verification_token', $request->verification_code)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->verification_token = null; 
        $user->save();

        return response()->json(['message' => 'Your password has been reset!']);
    }
}