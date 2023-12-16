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


    public function pay(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // コンビニ払いの場合は直接成功として扱い、SoldItemを作成
        if ($request->input('paymentMethod') === 'konbini') {
            $user = auth()->user();
            SoldItem::create([
                'users_id' => $user->id,
                'items_id' => $request->item_id,
            ]);

            return redirect()->route('buyComplete'); // リダイレクトするよう修正
        }

        if ($request->input('paymentMethod') === 'card') {
            // クレジットカード払いの場合はStripeを利用して決済
            $charge = Charge::create([
                'amount' => $request->input('item_price'),
                'currency' => 'jpy',
                'source' => $request->stripeToken,
            ]);

            // 現在ログインしているユーザーを取得
            $user = auth()->user();

            // 新しい SoldItem レコードを作成
            SoldItem::create([
                'users_id' => $user->id,
                'items_id' => $request->item_id,
            ]);

            return redirect()->route('buyComplete'); // リダイレクトするよう修正
        }
    }

    public function buyComplete()
    {
        return view('buyComplete');
    }
}