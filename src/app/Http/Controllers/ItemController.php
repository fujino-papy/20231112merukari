<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->search($request);
        }
        $recommendedItems = Item::inRandomOrder()->limit(40)->get();
        $favoriteItemIds = auth()->check() ? auth()->user()->favorites->pluck('items_id') : collect();
        $favoriteItems = Item::whereIn('id', $favoriteItemIds)->get();
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
        $productImagePath = $request->file('image')->store('uploads');

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

    public function detail($id)
    {
        $item = Item::find($id);
        $isFavorite = false;
        $favoriteCount = 0;
        $commentCount = 0;

        if (auth()->check()) {
            $favoriteItemIds = auth()->user()->favorites->pluck('items_id');
            $favoriteItems = Item::whereIn('id', $favoriteItemIds)->get();
            $isFavorite = $favoriteItemIds->contains($item->id);
        }

        $favoriteCount = Favorite::where('items_id', $item->id)->count();

        $comments = Comment::where('items_id', $item->id)->get();
        $commentCount = count($comments);

        return view('detail', [
            'item' => $item,
            'isFavorite' => $isFavorite,
            'favoriteCount' => $favoriteCount,
            'commentCount' => $commentCount,
        ]);
    }
}
