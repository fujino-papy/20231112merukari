<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller {
    public function favorite(Request $request, $itemId) {
        $userId = auth()->user()->id;

        $favorite = Favorite::where('items_id', $itemId)
            ->where('users_id', $userId)
            ->first();

        if(!$favorite) {
            $favorite = new Favorite();
            $favorite->users_id = $userId;
            $favorite->items_id = $itemId;
            $favorite->save();
        }

        $favorite = [$itemId => true];
        return back()->with('itemFavorites', $favorite);
    }

    public function favoriteDelete(Request $request, $itemId) {
        $userId = auth()->user()->id;

        $favorite = Favorite::where('items_id', $itemId)
            ->where('users_id', $userId)
            ->first();

        if($favorite) {
            $favorite->delete();
        }

        return back();
    }
}
