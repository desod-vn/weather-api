<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    const LIST = [
        'Hà Nội',
        'Đà Nẵng',
        'Hồ Chí Minh',
        'Hải Phòng',
        'Cần Thơ'
    ];

    public function weathers()
    {
        return $this->hasMany(Weather::class);
    }
}
