<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SoldItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Redirect;

class BuyController extends Controller
{
    public function buyPage($id)
    {
        $item = Item::find($id);

        session(['selected_item' => $item]);

        return view('buy', ['item' => $item]);
    }

    public function address()
    {
        $item = session('selected_item');

        return view('address', ['item' => $item]);
    }

    public function addressEdit(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $user->post = $request->filled('post') ? $request->input('post') : "";
        $user->address = $request->filled('address') ? $request->input('address') : "";
        $user->building_name = $request->filled('building_name') ? $request->input('building_name') : "";
        $user->save();

        $itemId = $request->input('item_id');
        $itemName = $request->input('item_name');
        $itemPrice = $request->input('item_price');

        return redirect()->route('buyPage', ['item_id' => $itemId])->with('success', '住所情報が変更されました');
    }
    public function konbiniPay(Request $request)
    {
        $user = auth()->user();
        SoldItem::create([
            'users_id' => $user->id,
            'items_id' => $request->item_id,
        ]);

        $item = Item::find($request->item_id);
        $item->sold = true;
        $item->save();

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::create([
                'payment_method_types' => ['konbini'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'JPY',
                            'product_data' => [
                                'name' => $item->name,
                            ],
                            'unit_amount' => $item->price,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('buyComplete'),
                'cancel_url' => route('index'),
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return Redirect::route('index')->with('error', $e->getMessage());
        }
    }

    public function cardPay(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $charge = Charge::create([
                'amount' => $request->input('item_price'),
                'currency' => 'jpy',
                'source' => $request->stripeToken,
            ]);

            if ($charge->status === 'succeeded') {
                $user = auth()->user();
                SoldItem::create([
                    'users_id' => $user->id,
                    'items_id' => $request->item_id,
                ]);

                $item = Item::find($request->item_id);
                $item->sold = true;
                $item->save();

                return redirect()->route('buyComplete');
            } else {
                return redirect()->route('index')->with('error');
            }
        } catch (Exception $e) {
            return redirect()->route('pay')->with('error', $e->getMessage());
        }
    }
    public function buyComplete()
    {
        return view('buyComplete');
    }
}