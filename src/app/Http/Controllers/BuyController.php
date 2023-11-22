<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{

    public function buyPage($id)
    {
        // Stripe API キーの設定
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $item = Item::find($id);

        // StripeのPaymentIntentを作成
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $item->price,  // 金額をセント単位に変換
            'currency' => 'JPY',
        ]);

        // PaymentIntentのクライアントシークレットをセッションに保存
        session()->put('paymentIntentId', $paymentIntent->id);

        return view('buy', [
            'item' => $item,
            'clientSecret' => $paymentIntent->client_secret,
            'paymentIntentId' => $paymentIntent->id, // PaymentIntentのIDをビューに渡す
        ]);
    }

    public function processPurchase(Request $request)
    {
        // Stripe API キーの設定
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // 生成されたトークンを取得
        $stripeToken = $request->input('stripeToken');

        // PaymentIntentのIDを取得
        $paymentIntentId = $request->input('paymentIntentId');

        try {
            // PaymentIntentを取得
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            // PaymentIntentに支払い手段を設定して確定
            $paymentIntent->confirm([
                'payment_method' => $stripeToken,
                'return_url' => 'http://localhost/',  // 成功時のリダイレクト先URLを適切なものに変更
            ]);

            // 支払いが成功した場合の処理

            // 支払い情報を保存等の処理を追加

            return redirect('/');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // エラーハンドリング
            return back()->with('error', $e->getMessage());
        }
    }
}
