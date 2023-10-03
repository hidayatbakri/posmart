<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goods = Good::where('user_id', Auth::user()->id)->with('category')->get();
        $title = "Daftar barang | POSmart";
        $activelink = "goods";
        return view('users.goods.index', compact('title', 'activelink', 'goods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah barang | POSmart";
        $activelink = "goods";
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('users.goods.create', compact('title', 'activelink', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $requestValidate = $request->validate([
            'name' => 'required',
            'selling_price' => 'required|integer',
            'photo' => $request->photo != null ? 'mimes:png,jpg,jepg|max:512' : '',
            'qr' => $request->qr != null ? 'integer' : '',
            'stock' => $request->stock != null ? 'integer' : '',
            'capital_price' => $request->capital_price != null ? 'integer' : '',
            'category_id' => $request->category_id != null ? 'integer' : '',
        ]);
        $request->photo != null ? $requestValidate['photo'] = $request->file('photo')->store('goods') : '';
        $requestValidate['description'] = $request->description ?? '';
        $requestValidate['stock'] = $request->stock ?? '9999999';

        // dd($requestValidate);

        $requestValidate['user_id'] = Auth::user()->id;

        Good::create($requestValidate);
        return redirect('/user/barang')->with('success', 'Berhasil menambah barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(Good $good, $id)
    {
        $title = "Ubah barang | POSmart";
        $activelink = "goods";
        $good = Good::with('category')->where('id', $id)->first();
        return view('users.goods.show', compact('title', 'activelink', 'good'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Good $good, $id)
    {
        $title = "Ubah barang | POSmart";
        $activelink = "goods";
        $categories = Category::where('user_id', Auth::user()->id)->get();
        $good = Good::with('category')->where('id', $id)->first();
        return view('users.goods.edit', compact('title', 'activelink', 'categories', 'good'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Good $good, $id)
    {
        $good = Good::where('id', $id)->first();
        $requestValidate = $request->validate([
            'name' => 'required',
            'selling_price' => 'required|integer',
            'photo' => $request->photo != null ? 'mimes:png,jpg,jepg|max:512' : '',
            'qr' => $request->qr != null ? 'integer' : '',
            'stock' => $request->stock != null ? 'integer' : '',
            'capital_price' => $request->capital_price != null ? 'integer' : '',
            'category_id' => $request->category_id != null ? 'integer' : '',
        ]);
        $requestValidate['description'] = $request->description ?? '';
        if ($request->photo != null) {
            Storage::disk()->delete($good->photo);
            $requestValidate['photo'] = $request->file('photo')->store('goods');
        } else {
            $requestValidate['photo'] = $good->photo;
        }
        $good->update($requestValidate);
        return redirect('/user/barang')->with('success', 'Berhasil mengubah barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Good $good, $id)
    {
        $good = Good::where('id', $id)->first();
        $good->photo ? Storage::disk()->delete($good->photo) : '';
        $good->delete();
        return redirect('/user/barang')->with('success', 'Berhasil menghapus barang');
    }
}
