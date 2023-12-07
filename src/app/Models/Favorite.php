<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'shops_id',
    ];

    public function item() {
        return $this->belongsTo(Item::class, 'items_id', 'id');
    }
}
