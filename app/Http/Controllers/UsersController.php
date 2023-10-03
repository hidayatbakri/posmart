<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Good;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Dashboard | POSmart';
        $activelink = 'dashboard';
        $subactivelink = 'home';
        $goods = Good::where('user_id', Auth::user()->id)->get();
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $categories = Category::where('user_id', Auth::user()->id)->get();
        $transactionsCart = Transaction::selectRaw('final_price as total_price, DATE_FORMAT(created_at, "%Y-%m") as month_year')
            ->where('user_id', Auth::user()->id)
            ->groupBy('month_year')
            ->groupBy('transaction_code')
            ->orderBy('created_at')
            ->limit(12)
            ->get();
        $transactionsPrice = Transaction::selectRaw('final_price as total_price, DATE_FORMAT(created_at, "%Y-%m") as month_year')
            ->where('user_id', Auth::user()->id)
            ->groupBy('transaction_code')
            ->get();

        $transactions = Transaction::where('user_id', Auth::user()->id)->groupBy('transaction_code')->limit(5)->get();
        $totalSellingPrice = $transactionsPrice->sum(function ($transaction) {
            return $transaction->total_price;
        });
        // dd($transactions);
        // $keys = $transactionsCart->keys();



        return view('users.index', compact('title', 'activelink', 'subactivelink', 'goods', 'carts', 'transactions', 'categories', 'totalSellingPrice', 'transactionsCart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
