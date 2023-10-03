<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Good;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionLive extends Component
{
    protected $listeners = ['searchData' => 'searchData', 'cartData' => 'cartData', 'getData' => 'getData', 'deleteData' => 'deleteData'];
    public $goods;
    public $cart;
    public $goodsInCart;
    public function mount()
    {
        $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
        $this->cart = Cart::where('user_id', Auth::user()->id)->get();
        $goodIds = $this->goods->pluck('id')->toArray();
        $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
    }

    public function render()
    {
        return view('livewire.transaction-live');
    }

    public function getData()
    {
        // $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
        // $this->cart = Cart::where('user_id', Auth::user()->id)->get();
        // $goodIds = $this->goods->pluck('id')->toArray();
        // $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
    }

    public function searchData($input)
    {
        $this->goods = Good::with('category')
            ->where('user_id', Auth::user()->id)
            ->Where('name', 'like', '%' . $input . '%')
            ->orWhere('qr', 'like', '%' . $input . '%')
            ->get();
    }

    public function cartData($data)
    {
        $cart = [
            'user_id' => Auth::user()->id,
            'good_id' => $data
        ];
        $stock = Good::where('id', $data)->first();
        if ($stock->stock > 0) {
            Cart::where('good_id', $data)->first() ? '' : Cart::create($cart);
            $stock->update(['stock' => $stock->stock - 1]);
            $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
            $this->cart = Cart::where('user_id', Auth::user()->id)->get();
            $goodIds = $this->goods->pluck('id')->toArray();
            $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
        }
        return;
    }

    public function deleteData($id)
    {
        // Cart::where('good_id', $id)->where('user_id', Auth::user()->id)->delete();
        // return redirect('/user/transaksi');
    }
}
