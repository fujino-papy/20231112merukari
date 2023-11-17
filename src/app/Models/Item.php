<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'name',
        'categories_id',
        'conditions_id',
        'summary',
        'image_url',
        'price',
        'sold',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class, 'conditions_id');
    }
}
