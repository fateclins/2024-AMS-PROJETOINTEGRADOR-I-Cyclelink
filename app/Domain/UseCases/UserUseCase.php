<?php

namespace App\Domain\UseCases;

use App\Infra\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Domain\Entities\User;

class UserUseCase
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
    
    public function getAll()
    {
        return $this->UserRepository->getAll();
    }

    public function find(int $id)
    {
        return $this->UserRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->UserRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->UserRepository->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->UserRepository->destroy($id);
    }

    public function signIn(Request $request){
        return $this->UserRepository->signIn($request);
    }

    public function login(Request $request){
        return $this->UserRepository->login($request);
    }

    public function logout(Request $request){
        return $this->UserRepository->logout($request);
    }

    public function sendEmail(Request $request){
        return $this->UserRepository->sendEmail($request);
    }

    public function resetPassword(Request $request){
        return $this->UserRepository->resetPassword($request);
    }
}
