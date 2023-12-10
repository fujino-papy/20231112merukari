<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function comment($id)
    {
    {
        $item = Item::find($id);
        $isFavorite = false;

        if (auth()->check()) {
            $userFavorites = auth()->user()->favorites;

            if ($userFavorites && $userFavorites->contains('items_id', $item->id)) {
                $isFavorite = true;
            }
        }

        // コメント一覧を取得（ここでは3件取得している例）
        $comments = Comment::where('items_id', $item->id)
                            ->limit(3)
                            ->get();
        return view('comment', ['item' => $item, 'isFavorite' => $isFavorite, 'comments' => $comments]);
    }
    }

    public function commentPost(Request $request)
    {
        // ログインしているユーザーのIDを取得
        $userId = auth()->id();
        // コメントをデータベースに保存
        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->users_id = $userId;
        $comment->items_id = $request->input('item_id');
        $comment->save();
        // リダイレクト先やメッセージを適宜追加
        return redirect()->route('detail', ['item_id' => $request->input('item_id')])->with('success', 'コメントが投稿されました');
    }
}

