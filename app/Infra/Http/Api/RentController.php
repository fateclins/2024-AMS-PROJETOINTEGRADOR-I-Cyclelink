<?php

namespace App\Infra\Http\Api;

use App\Domain\Entities\Rent;
use App\Infra\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class RentController extends Controller
{

    public function index(Request $request)
    {
        $query = Rent::with(['bike.typeBike', 'bike.brand']); // Include related data

        // Apply filters
        if ($request->filled('brand_id')) {
            $query->whereHas('bike', fn($q) => $q->where('brand_id', $request->brand_id));
        }

        if ($request->filled('type_bike_id')) {
            $query->whereHas('bike', fn($q) => $q->where('type_bike_id', $request->type_bike_id));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Paginate results
        $rents = $query->paginate(10);

        return response()->json($rents);
    }
    /**
     * Create a new rent and assign it to the authenticated user.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'bike_id' => 'required|exists:bikes,id',
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('rents', 'public');
        }

        $rent = Rent::create([
            'bike_id' => $request->bike_id,
            'user_id' => Auth::id(),
            'price' => $request->price,
            'color' => $request->color,
            'photo_path' => $photoPath,
        ]);

        return response()->json($rent, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $rent = Rent::findOrFail($id);

        if (Auth::id() !== $rent->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('photo')) {
            if ($rent->photo_path && Storage::exists('public/' . $rent->photo_path)) {
                Storage::delete('public/' . $rent->photo_path);
            }
            $photoPath = $request->file('photo')->store('rents', 'public');
            $rent->photo_path = $photoPath;
        }

        $rent->update([
            'price' => $request->price,
            'color' => $request->color,
        ]);

        return response()->json($rent);
    }

    /**
     * Delete a rent record.
     */
    public function destroy($id)
    {
        $rent = Rent::findOrFail($id);

        if (Auth::id() !== $rent->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($rent->photo_path && Storage::exists('public/' . $rent->photo_path)) {
            Storage::delete('public/' . $rent->photo_path);
        }

        $rent->delete();

        return response()->json(['message' => 'Rent deleted successfully.'], Response::HTTP_NO_CONTENT);
    }

    public function getAll(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $rents = Rent::with('bike')
                    ->paginate($perPage);

        return response()->json($rents);
    }

    /**
     * Show a single rent by ID.
     */
    public function show($id)
    {
        // Find the rent by ID
        $rent = Rent::findOrFail($id);

        // Return the rent data
        return response()->json($rent);
    }
}
