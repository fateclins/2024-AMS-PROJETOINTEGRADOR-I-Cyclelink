<?php

namespace App\Infra\Http\Api;

use App\Domain\Entities\Brand;
use App\Domain\Entities\Rent;
use App\Infra\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        $query = Brand::all();
        return response()->json($query);
    }
}
