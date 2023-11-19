<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class BuyController extends Controller
{
    public function buyPage($id)
    {
        $item = Item::find($id);

        return view('buy', ['item' => $item]);
    }

    public function processPayment(Request $request, $itemId)
    {
        // Stripe初期化
        Stripe::setApiKey(config('services.stripe.secret'));

        // 商品情報をデータベースから取得
        $item = Item::findOrFail($itemId);

        // Stripe PaymentIntentを作成
        $intent = PaymentIntent::create([
            'amount' => $item->price * 100,  // 金額はセント単位で指定
            'currency' => 'JPY',
        ]);

        // PaymentIntentのIDをセッションに保存
        session()->put('paymentIntentId', $intent->id);

        // 購入ページにリダイレクト
        return view('payments.checkout', compact('item', 'intent'));
    }

    public function completePayment(Request $request)
    {
        // PaymentIntentのIDを取得
        $paymentIntentId = session()->get('paymentIntentId');

        // 支払い確定
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        $paymentIntent->confirm();

        // 支払いが成功した場合の処理

        // 支払い情報を保存等の処理を追加

        // セッションのクリア
        session()->forget('paymentIntentId');

        return view('payments.success');
    }

}
