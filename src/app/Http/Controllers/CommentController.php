<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CommentController extends Controller
{
    public function comment($id)
    {
        $item = Item::find($id);
        $userFavorites = auth()->user()->favorites;

        $isFavorite = false;

        if ($userFavorites && $userFavorites->contains('items_id', $item->id)) {
            $isFavorite = true;
        }
        return view('comment', ['item' => $item, 'isFavorite' => $isFavorite]);
    }

    public function commentPost()
    {
        redirect('detail');
    }
}

