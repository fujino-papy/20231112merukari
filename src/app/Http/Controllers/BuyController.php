<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{

    public function buyPage($id)
    {
        // Stripe API キーの設定
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        if (request()->isMethod('post')) {
            $item = Item::find($id);

            // StripeのPaymentIntentを作成
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $item->price,  // 金額をセント単位に変換
                'currency' => 'JPY',
                'payment_method_types' => ['card'],
            ]);

            // PaymentIntentのクライアントシークレットをセッションに保存
            session()->put('paymentIntentId', $paymentIntent->id);
        }
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

        // ログインユーザーの情報を取得
        $user = Auth::user();

        // 生成されたトークンを取得
        $stripeToken = $request->input('stripeToken');

        // PaymentIntentのIDを取得
        $paymentIntentId = $request->input('paymentIntentId');

        try {
            // ユーザーがStripeの顧客でなければ作成する
            if (!$user->stripe_customer_id) {
                $customer = Customer::create([
                    'email' => $user->email,
                    // 他にも必要な情報を追加
                ]);

                // ユーザーにStripeの顧客IDを保存
                $user->update(['stripe_customer_id' => $customer->id]);
            }

            // PaymentIntentを取得
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            // PaymentIntentに支払い手段と顧客情報を設定して確定
            $paymentIntent->confirm([
                'payment_method' => $stripeToken,
                'customer' => $user->stripe_customer_id,
            ]);

            return redirect('/items');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // エラーハンドリング
            return back()->with('error', $e->getMessage());
        }
    }

    public function buyComplete()
    {
        return view('buyComplete');
    }
}
