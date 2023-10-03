<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartLive extends Component
{
    public $carts;

    protected $listeners = ['submitData' => 'submitData'];

    public function mount()
    {
        $this->carts = Cart::where('user_id', Auth::user()->id)->with('good')->get();
    }

    public function render()
    {
        return view('livewire.cart-live');
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
        // dd($diskon);
        Cart::where('user_id', Auth::user()->id)->delete();
        Transaction::create($data);

        return redirect('/user/success/' . $code);
    }
}
