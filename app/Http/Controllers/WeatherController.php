<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $weather = Weather::query()
            ->where('city_id', $request->city);

        if (!empty($request->number)) {
            $weather = $weather
                ->whereBetween('date', [
                    Carbon::now()->subDays($request->number),
                    Carbon::now()->addDays($request->number)
                ]);
        } else if (!empty($request->week)) {
            $weather = $weather
                ->whereBetween('date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
        } else if (!empty($request->month)) {
            $weather = $weather
                ->whereBetween('date', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
        } else {
            $weather = $weather
            ->where('date', Carbon::now()->startOfDay());
        }
        return response()->json([
            'success' => true,
            'data' => $weather->get()
        ], 200);
    }
}
