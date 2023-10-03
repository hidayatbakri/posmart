<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Good;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CashierLive extends Component
{
    protected $listeners = ['searchData' => 'searchData', 'cartData' => 'cartData', 'getData' => 'getData', 'cartDataByBarcode' => 'cartDataByBarcode', 'setTotalCart' => 'setTotalCart', 'submitData' => 'submitData'];
    public $goods = [];
    public $cart;
    public $goodsInCart;

    public function mount()
    {
        // $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
        $this->cart = Cart::with('good')->where('user_id', Auth::user()->id)->get();
        // $goodIds = $this->goods->pluck('id')->toArray();
        // $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
    }

    public function getData()
    {
        // $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
        $this->cart = Cart::with('good')->where('user_id', Auth::user()->id)->get();

        // $goodIds = $this->goods->pluck('id')->toArray();
        // $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
    }

    public function render()
    {
        return view('livewire.cashier-live');
    }

    public function searchData($input)
    {
        if ($input) {
            $this->goods = Good::with('category')
                ->where('user_id', Auth::user()->id)
                ->Where('name', 'like', '%' . $input . '%')
                ->orWhere('qr', 'like', '%' . $input . '%')
                ->get();
            $this->setTotalCart();
        } else {
            $this->goods = [];
        }
    }

    public function cartData($data)
    {
        $cart = [
            'user_id' => Auth::user()->id,
            'good_id' => $data
        ];
        Cart::where('good_id', $data)->first() ? '' : Cart::create($cart);

        $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
        $this->cart = Cart::with('good')->where('user_id', Auth::user()->id)->get();
        $goodIds = $this->goods->pluck('id')->toArray();
        $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
        $this->setTotalCart();
        return;
    }

    public function setTotalCart()
    {
        $this->cart = Cart::with('good')->where('user_id', Auth::user()->id)->get();
        $this->dispatch('setTotal', ['carts' => json_encode($this->cart)]);
    }

    public function cartDataByBarcode($data)
    {
        $good = Good::where('qr', $data)->first();
        if ($good) {
            $cart = [
                'user_id' => Auth::user()->id,
                'good_id' => $good->id
            ];
            Cart::where('good_id', $good->id)->first() ? '' : Cart::create($cart);

            $this->goods = Good::with('category')->where('user_id', Auth::user()->id)->get();
            $this->cart = Cart::with('good')->where('user_id', Auth::user()->id)->get();
            $goodIds = $this->goods->pluck('id')->toArray();
            $this->goodsInCart = Cart::whereIn('good_id', $goodIds)->get();
        }
        return;
    }

    public function submitData($code, $id, $quantity, $bayar, $total, $diskon)
    {
        $data = [
            'transaction_code' => $code,
            'user_id' => Auth::user()->id,
            'good_id' => $id,
            'quantity' => $quantity,
            'gross_amount' => $bayar,
            'final_price' => $total,
            'discon' => $diskon
        ];
        Cart::where('user_id', Auth::user()->id)->delete();
        Transaction::create($data);

        return redirect('/user/success/' . $code);
    }
}
