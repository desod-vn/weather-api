<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const LIST =[
        'Chính trị xã hội',
        'Đời sống',
        'Khoa học',
        'Kinh doanh',
        'Pháp luật',
        'Sức khỏe',
        'Thế giới',
        'Thể thao',
        'Văn hóa',
        'Vi tính',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
