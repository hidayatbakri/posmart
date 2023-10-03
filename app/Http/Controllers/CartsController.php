<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Keranjang | POSmart';
        $activelink = 'transaction';


        return view('users.cart.index', compact('title', 'activelink'));
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
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, $id)
    {
        Cart::where('good_id', $id)->delete();
        $stock = Good::where('id', $id)->first();
        $stock->update(['stock' => $stock->stock + 1]);
        return redirect()->back();
    }
}
