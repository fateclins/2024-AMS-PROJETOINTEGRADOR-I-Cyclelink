<?php

namespace App\Infra\Http\Api;

use App\Domain\Entities\Bike;
use App\Domain\Entities\User;
use App\Infra\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BikeController extends Controller
{
    public function index()
    {
        return response()->json(Bike::all());
    }
}


?>