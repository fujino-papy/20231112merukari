<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class BuyController extends Controller
{
    public function buyPage($id)
    {
        $item = Item::find($id);

        return view('buy', ['item' => $item]);
    }

    public function buyComplete()
    {
        return view('buyComplete');
    }

        public function pay(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); // シークレットキー

        $charge = Charge::create(
            array(
                'amount' => $request->input('item_price'),
                'currency' => 'jpy',
                'source' => $request->stripeToken,
            )
        );

        // 現在ログインしているユーザーを取得
        $user = auth()->user();

        // 新しい SoldItem レコードを作成
        SoldItem::create([
            'users_id' => $user->id,
            'items_id' => $request->item_id,
        ]);

        return view('buyComplete');
    }
}