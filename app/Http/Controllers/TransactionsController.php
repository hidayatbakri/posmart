<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Good;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $title = "Transaksi barang | POSmart";
        $activelink = "transaction";
        return view('users.transaction.index', compact('title', 'activelink'));
    }

    public function cashier()
    {

        $title = "Transaksi barang | POSmart";
        $activelink = "transaction";
        return view('users.transaction.cashier', compact('title', 'activelink'));
    }

    public function success($id)
    {

        $title = "Transaksi | POSmart";
        $activelink = "transaction";
        $transactions = Transaction::with('good')->where([['transaction_code', $id], ['user_id', Auth::user()->id]])->get();
        $transaction = Transaction::where([['transaction_code', $id], ['user_id', Auth::user()->id]])->groupBy('transaction_code')->first();
        return view('users.transaction.success', compact('title', 'activelink', 'transaction', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function recap()
    {
        $title = "Rekap Transaksi | POSmart";
        $activelink = "rekap";
        $transactions = Transaction::where('user_id', Auth::user()->id)->groupBy('transaction_code')->get();
        return view('users.transaction.recap', compact('title', 'activelink', 'transactions'));
    }

    public function detailRecap($id)
    {
        $title = "Rekap Transaksi | POSmart";
        $activelink = "rekap";
        $transactions = Transaction::with('good')->where([['transaction_code', $id], ['user_id', Auth::user()->id]])->get();
        $transaction = Transaction::where([['transaction_code', $id], ['user_id', Auth::user()->id]])->groupBy('transaction_code')->first();
        return view('users.transaction.detailRecap', compact('title', 'activelink', 'transaction', 'transactions'));
    }

    public function recapPrint($id)
    {
        $title = "Rekap Transaksi | POSmart";
        $activelink = "rekap";
        $transactions = Transaction::with('good')->where([['transaction_code', $id], ['user_id', Auth::user()->id]])->get();
        $transaction = Transaction::where([['transaction_code', $id], ['user_id', Auth::user()->id]])->groupBy('transaction_code')->first();
        return view('users.transaction.print', compact('title', 'activelink', 'transaction', 'transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function simpan(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $i = 0;
        foreach ($carts as $row) {
            $data = [
                'user_id' => Auth::user()->id,
                'good_id' => $row->good_id,
            ];

            Transaction::create($data);
            $i++;
        }

        Cart::where('user_id', Auth::user()->id)->delete();
        return redirect('/user/transaksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction, $id)
    {
        $req = $request->validate([
            'gross_amount' => 'integer|required'
        ]);

        Transaction::where([['id', $id], ['user_id', Auth::user()->id]])->update($req);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
