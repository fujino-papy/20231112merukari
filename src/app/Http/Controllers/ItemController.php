<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // 検索クエリが存在するかを確認
        if ($request->has('query')) {
            return $this->search($request);
        }

        // おすすめアイテムを取得（例としてランダムに取得）
        $recommendedItems = Item::inRandomOrder()->limit(40)->get();

        // ログインユーザーがお気に入りしているアイテムのIDを取得
        $favoriteItemIds = auth()->check() ? auth()->user()->favorites->pluck('items_id') : collect();

        // お気に入りしているアイテムの詳細情報を取得
        $favoriteItems = Item::whereIn('id', $favoriteItemIds)->get();

        // 通常のアイテム一覧を取得
        $items = Item::paginate(40);

        foreach ($items as $item) {
            $item->isSoldOut = $item->sold;
        }

        return view('index', compact('items', 'recommendedItems', 'favoriteItems'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $items = Item::where('name', 'like', '%' . $query . '%')->paginate(40);

        $favoriteItems = auth()->check() ? auth()->user()->favorites : collect();

        foreach ($items as $item) {
            $item->isSoldOut = $item->sold;
        }

        return view('index', compact('items', 'query', 'favoriteItems'));
    }

    public function exhibit()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('exhibit', compact('categories', 'conditions'));
    }

    public function store(StoreItemRequest $request)
    {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $productImagePath = $request->file('product_image')->store('products');

        $item = new Item();
        $item->users_id = auth()->user()->id;
        $item->categories_id = $request->input('category_id');
        $item->conditions_id = $request->input('condition_id');
        $item->name = $request->input('name');
        $item->summary = $request->input('summary');
        $item->image_url = '/storage/' . $productImagePath;
        $item->price = $request->input('price');
        $item->save();

        return redirect('/');
    }

    public function detail($id) {
    $item = Item::find($id);
    $isFavorite = false;

    if(auth()->check()) {
        $userFavorites = auth()->user()->favorites;

        if($userFavorites && $userFavorites->contains('items_id', $item->id)) {
            $isFavorite = true;
        }
    }

    return view('detail', ['item' => $item, 'isFavorite' => $isFavorite]);
}
}
