<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class BuyController extends Controller
{
    public function buyPage($id)
    {
        $item = Item::find($id);

        return view('buy', ['item' => $item]);
    }
}
