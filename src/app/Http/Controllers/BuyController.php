<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class BuyController extends Controller
{
    public function buyPage($id)
    {
        // 商品を取得
        $item = Item::find($id);

        // GET リクエストの場合は購入ページを表示
        return view('buy', ['item' => $item]);
    }
    public function processPayment(Request $request, $item_id)
    {
        // ユーザーのIDや他の必要な情報を取得
        $user_id = auth()->user()->id;

        // StripeのAPIキーを設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // 商品の情報を取得
        $item = Item::find($item_id);

        // 決済方法を取得
        $paymentMethod = $request->input('PaymentMethod');

        try {
            // 顧客情報をStripeに登録
            $customer = Customer::create([
                'email' => auth()->user()->email,
                // 他の顧客情報を追加
            ]);

            // 決済オプションの設定
            $paymentOptions = [
                'amount' => $item->price, // 金額をセント単位に変換
                'currency' => 'JPY',
                'customer' => $customer->id,
            ];

            // クレジットカード払いの場合はPaymentMethodを取得
            if ($paymentMethod === 'card') {
                $paymentMethodId = $request->input('stripePaymentMethod');

                // カード情報をStripeにアタッチ
                $paymentOptions['payment_method'] = $paymentMethodId;
                $customer->invoice_settings = [
                    'default_payment_method' => $paymentMethodId,
                ];
                $customer->save();
            }

            $paymentMethod = PaymentMethod::create($paymentMethod);

            // 決済を実行
            $paymentIntent = PaymentIntent::create($paymentOptions);

            // 決済が成功した場合の処理

            // Indexにリダイレクト
            return redirect()->route('index')->with('success', '決済が完了しました。');
        } catch (\Exception $e) {
            // エラーが発生した場合の処理
            return back()->withErrors(['paymentError' => $e->getMessage()]);
        }
    }
}