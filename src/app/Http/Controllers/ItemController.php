<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(40); // 1ページに5つのアイテムを表示すると仮定
        return view('index', compact('items'));
    }
}
