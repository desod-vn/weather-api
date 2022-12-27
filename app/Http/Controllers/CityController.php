<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        return response()->json([
            'success' => true,
            'cities' => $cities
        ], 200);
    }
}
