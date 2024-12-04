<?php

namespace App\Infra\Http\Api;

use App\Domain\UseCases\UserUseCase;
use App\Infra\Http\Requests\LoginFormRequest;
use App\Infra\Http\Requests\ResetPasswordRequest;
use App\Infra\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    protected $userUseCase;

    public function __construct(UserUseCase $userUseCase)
    {
        $this->userUseCase = $userUseCase;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function signIn(UserFormRequest $request){
        return $this->userUseCase->signIn($request);
    }

    public function login(LoginFormRequest $request){
        return $this->userUseCase->login($request);
    }

    public function sendEmail(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        return $this->userUseCase->sendEmail($request);
    }

    public function resetPassword(ResetPasswordRequest $request){
        return $this->userUseCase->resetPassword($request);
    }
    
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Successfully logged out.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to log out.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function isAuth()
    {
        $user = auth()->user();

        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
