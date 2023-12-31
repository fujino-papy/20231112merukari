<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/',[ItemController::class,'index'])->name('index');
Route::get('/exhibit', [ItemController::class,'exhibit']);
Route::get('/search', [ItemController::class, 'search'])->name('search');

Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('detail');
Route::get('/buy/{item_id}', [BuyController::class, 'buyPage'])->name('buyPage');
Route::post('/konbiniPay', [BuyController::class, 'konbiniPay'])->name('konbiniPay');
Route::post('/cardPay', [BuyController::class, 'cardPay'])->name('cardPay');
Route::get('/address', [BuyController::class, 'address'])->name('address');
Route::post('/address/edit', [BuyController::class, 'addressEdit'])->name('addressEdit');
Route::get('/buyComplete', [BuyController::class, 'buyComplete'])->name('buyComplete');
Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');
Route::get('/profile', [MypageController::class, 'profile'])->name('profile');
Route::post('profile/edit',[MypageController::class,'profileEdit'])->name('profileEdit');
Route::post('/favorite/{item_id}', [FavoriteController::class, 'favorite'])->name('favorite');
Route::delete('/favorite/delete/{item_id}', [FavoriteController::class, 'favoriteDelete'])->name('favoriteDelete');
Route::get('/comment/{item_id}', [CommentController::class, 'comment'])->name('comment');
Route::post('/comment', [CommentController::class, 'commentPost'])->name('commentPost');