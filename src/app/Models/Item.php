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
}
