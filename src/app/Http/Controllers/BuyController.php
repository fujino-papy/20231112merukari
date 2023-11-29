<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        Stripe::setApiKey(env('STRIPE_SECRET')); //シークレットキー

        $charge = Charge::create(
            array(
                'amount' => $request->input('item_price'),
                'currency' => 'jpy',
                'source' => request()->stripeToken,
            )
        );
        return view('buyComplete');
    }
}