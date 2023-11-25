<?php

namespace App\Http\Controllers;

use App\Models\Item;


class BuyController extends Controller
{

    public function buyPage($id)
    {
        // 商品を取得
        $item = Item::find($id);

        // GET リクエストの場合は購入ページを表示
        return view('buy', ['item' => $item]);
    }



}
