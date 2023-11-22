<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BuyController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/',[ItemController::class,'index'])->name('index');
Route::get('/exhibit', [ItemController::class,'exhibit']);

Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/item/{id}', [ItemController::class, 'detail'])->name('detail');
Route::post('/buy/{item_id}', [BuyController::class, 'buyPage'])->name('buyPage');
Route::post('/items/{item}/purchase', [BuyController::class, 'processPurchase'])->name('items.purchase');