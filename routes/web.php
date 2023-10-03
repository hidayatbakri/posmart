<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return redirect('/login');
})->middleware('guest');
Route::get('/home', [AuthController::class, 'checkLevel'])->middleware('auth');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/login', [AuthController::class, 'index'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::get('/activate', [AuthController::class, 'activate'])->middleware('guest');
Route::resource('/auth', AuthController::class)->middleware('guest');

Route::middleware(['checkLevel:user'])->group(function () {
  Route::get('/user/success/{id}', [TransactionsController::class, 'success']);
  Route::get('/user/rekap', [TransactionsController::class, 'recap']);
  Route::get('/user/rekap/print/{id}', [TransactionsController::class, 'recapPrint']);
  Route::get('/user/rekap/{id}', [TransactionsController::class, 'detailRecap']);
  Route::get('/user/transaksi/kasir', [TransactionsController::class, 'cashier']);
  Route::delete('/user/transaksi', [TransactionsController::class, 'simpan']);
  Route::resource('/user/transaksi', TransactionsController::class);
  Route::resource('/user/keranjang', CartsController::class);
  Route::resource('/user/category', CategoriesController::class);
  Route::resource('/user/barang', GoodsController::class);
  Route::resource('/user', UsersController::class);
});
