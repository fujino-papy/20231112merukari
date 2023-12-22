<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyPageRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Storage;

class MyPageController extends Controller
{

    public function mypage()
    {
        $user = Auth::user();
        $sellingItems = Item::where('users_id', $user->id)->get();
        $buyingItems = SoldItem::where('users_id', $user->id)->get();

        $boughtItemsDetails = [];
        foreach ($buyingItems as $buyingItem) {
            $item = Item::find($buyingItem->items_id);
            if ($item) {
                $boughtItemsDetails[] = $item;
            }
        }
        return view('mypage', ['sellingItems' => $sellingItems, 'boughtItemsDetails' => $boughtItemsDetails]);
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileEdit(MypageRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->filled('name') ? $request->input('name') : "";
        $user->post = $request->filled('post') ? $request->input('post') : "";
        $user->address = $request->filled('address') ? $request->input('address') : "";
        $user->building_name = $request->filled('building_name') ? $request->input('building_name') : "";

        if ($request->hasFile('img_url')) {
            if ($user->img_url) {
                Storage::disk('public')->delete($user->img_url);
            }
            $profileImagePath = $request->file('img_url')->store('profiles', 'public');
            $user->img_url = '/storage/' . $profileImagePath;
        }

        $user->save();
        return back()->with('success', 'プロフィールが正常に更新されました');
    }

}
