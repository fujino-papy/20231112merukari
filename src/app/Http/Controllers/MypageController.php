<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Storage;

class MypageController extends Controller
{

    public function mypage()
    {
        // 現在の認証されたユーザーを取得
        $user = Auth::user();

        // ユーザーが出品した商品を取得
        $sellingItems = Item::where('users_id', $user->id)->get();

        // ユーザーが購入した商品のデータを取得
        $buyingItems = SoldItem::where('users_id', $user->id)->get();

        // 購入した商品に関連するアイテムの詳細を取得
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

    public function profileEdit(Request $request)
    {
        // フォームデータのバリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'post' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 必要に応じてファイルタイプとサイズを調整
        ]);

        // 認証済みユーザーを取得
        $user = Auth::user();

        // ユーザー情報を更新
        $user->name = $request->input('name');
        $user->post = $request->input('post');
        $user->address = $request->input('address');
        $user->building_name = $request->input('building_name');
        $profileImagePath = $request->file('img_url')->store('profiles', 'public');
        // プロフィール画像のアップロードを処理
        if ($request->hasFile('img_url')) {
            // 以前のプロフィール画像が存在する場合は削除
            if ($user->img_url) {
                Storage::disk('public')->delete($user->img_url);
            }

            // 新しいプロフィール画像を保存
            $user->img_url = '/storage/' . $profileImagePath; // publicディレクトリ内にアップロードされた画像へのパス
        }

        // 変更を保存
        $user->save();

        // 成功メッセージと共にリダイレクト
        return back()->with('success', 'プロフィールが正常に更新されました');
    }
}
