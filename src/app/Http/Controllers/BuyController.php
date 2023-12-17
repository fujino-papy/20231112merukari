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


    public function konbiniPay(Request $request)
    {
        // コンビニ払いの場合は直接成功として扱い、SoldItemを作成
        $user = auth()->user();
        SoldItem::create([
            'users_id' => $user->id,
            'items_id' => $request->item_id,
        ]);

        $item = Item::find($request->item_id);
        $item->sold = true;
        $item->save();
        return redirect()->route('buyComplete');
    }

    public function cardPay(Request $request)
    {
        // クレジットカード払いの場合はStripeを利用して決済
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // ここにStripeの処理を追加
            $charge = Charge::create([
                'amount' => $request->input('item_price'),
                'currency' => 'jpy',
                'source' => $request->stripeToken,
            ]);

            // Stripeの処理が成功した場合、buyCompleteにリダイレクト
            if ($charge->status === 'succeeded') {
                // 現在ログインしているユーザーを取得
                $user = auth()->user();

                // 新しい SoldItem レコードを作成
                SoldItem::create([
                    'users_id' => $user->id,
                    'items_id' => $request->item_id,
                ]);

                $item = Item::find($request->item_id);
                $item->sold = true;
                $item->save();

                return redirect()->route('buyComplete');
            } else {
                // 決済が失敗した場合、/payにリダイレクト
                return redirect()->route('index')->with('error');
            }
        }
    catch (Exception $e) {
        // エラーが発生した場合の処理
        return redirect()->route('pay')->with('error', $e->getMessage());
    }
    }
    public function buyComplete()
    {
        return view('buyComplete');
    }
}