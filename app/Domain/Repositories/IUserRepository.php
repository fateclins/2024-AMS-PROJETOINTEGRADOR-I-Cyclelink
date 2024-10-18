<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\IDataRepository;
use Illuminate\Http\Request;

interface IUserRepository extends IDataRepository
{
    public function login(Request $request);
    public function logout(Request $request);
    public function signIn(Request $request);
    public function sendEmail(Request $request);
    public function resetPassword(Request $request);
}
