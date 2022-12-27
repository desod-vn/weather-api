<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Weather;
use App\Models\City;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WeatherSeeder extends Seeder
{
    const TEMP_BY_MONTH = [
        '1' => 12,
        '2' => 15,
        '3' => 20,
        '4' => 25,
        '5' => 27,
        '6' => 30,
        '7' => 35,
        '8' => 35,
        '9' => 30,
        '10' => 25,
        '11' => 20,
        '12' => 15,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $cities = City::all();
        foreach ($cities as $city) {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
            $theNextDay = $startDate;
            while ($theNextDay->lessThanOrEqualTo($endDate)) {
                $month = $theNextDay->month;
                $temp_morning = $this->getTemp($city->id, $month);
                $temp_night = $this->getTemp($city->id, $month);
                $rain_morning = rand(10, 100);
                $rain_night = rand(10, 100);
                $cloud_morning = $this->getCloud($rain_morning);
                $cloud_night = $this->getCloud($rain_night);
                $wind_morning = rand(3, 15);
                $wind_night = rand(3, 15);
                $sunRise = "05:" . $month * 3 + rand(1, 20);
                $sunSet = "18:" . $month * 3 + rand(1, 20);
                $moonRise = "05:" . $month * 3 + rand(1, 20);
                $moonSet = "18:" . $month * 3 + rand(1, 20);
                $data[] = [
                    'city_id' => $city->id,
                    'date' => $theNextDay->toDateString(),
                    'content' => json_encode([
                        'morning' => [
                            'temp' => $temp_morning,
                            'rain' => $rain_morning,
                            'cloud' => $cloud_morning,
                            'wind' => $wind_morning,
                            'sunRise' => $sunRise,
                            'sunSet' => $sunSet,
                        ],
                        'night' => [
                            'temp' => $temp_night,
                            'rain' => $rain_night,
                            'cloud' => $cloud_night,
                            'wind' => $wind_night,
                            'moonRise' => $moonRise,
                            'moonSet' => $moonSet,
                        ]
                    ])
                ];
                $theNextDay = $theNextDay->addDays(1);
            }
        }
        Weather::insert($data);
    }

    public function getTemp($cityId, $month)
    {
        $temp = self::TEMP_BY_MONTH[$month];
        switch ($cityId) {
            case 1: // Ha Noi
                $temp = rand($temp - 1, $temp + 1);
                break;
            case 2: // Da Nang
                $temp = rand($temp + 2, $temp + 2);
                break;
            case 3: // Ho Chi Minh
                $temp = rand($temp + 3, $temp + 3);
                break;
            case 4: // Hai Phong
                $temp = rand($temp - 1, $temp + 2);
                break;
            case 5: // Can Tho
                $temp = rand($temp + 3, $temp + 3);
                break;
            default:
                break;
        }
        return $temp;
    }

    public function getCloud($rain)
    {
        if ($rain < 20) {
            return "Trời quang";
        }
        if ($rain >= 20 && $rain < 40) {
            return "Trời có mây";
        }
        if ($rain >= 40 && $rain < 50) {
            return "Trời có rất nhiều mây";
        }
        if ($rain >= 50 && $rain < 60) {
            return "Trời có thể mưa rải rác";
        }
        if ($rain >= 60 && $rain < 75) {
            return "Giông bão";
        }
        if ($rain > 75) {
            return "Cảnh báo siêu bão";
        }
    }
}
