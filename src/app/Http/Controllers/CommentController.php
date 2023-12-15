<?php

namespace App\Http\Controllers;

use \App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;
class CommentController extends Controller
{
    public function comment($id)
    {
        $item = Item::find($id);
        $isFavorite = false;
        $commentCount = 0;
        $favoriteCount = 0; // お気に入りの数を初期化

        // ログインしているかどうかで処理を分ける
        if (auth()->check()) {
            $userFavorites = auth()->user()->favorites;

            if ($userFavorites && $userFavorites->contains('items_id', $item->id)) {
                $isFavorite = true;
            }

            // お気に入りの数を取得
            $favoriteCount = Favorite::where('items_id', $item->id)->count();
        } else {
            // ログインしていない場合はデータベースから直接お気に入りの数を取得
            $favoriteCount = Favorite::where('items_id', $item->id)->count();
        }

        // コメントの数を取得
        $comments = Comment::where('items_id', $item->id)->get();
        $commentCount = count($comments);

        return view('comment', [
            'item' => $item,
            'isFavorite' => $isFavorite,
            'comments' => $comments,
            'commentCount' => $commentCount,
            'favoriteCount' => $favoriteCount, // お気に入りの数をビューファイルに渡す
        ]);
    }

    public function commentPost(CommentRequest $request)
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

