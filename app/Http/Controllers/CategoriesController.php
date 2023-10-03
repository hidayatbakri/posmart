<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::user()->id)->with('goods')->get();
        $title = "Daftar Kategori | POSmart";
        $activelink = "category";
        return view('users.category.index', compact('title', 'activelink', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Kategori | POSmart";
        $activelink = "category";
        return view('users.category.create', compact('title', 'activelink'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required'
        ]);

        $requestValidate['user_id'] = Auth::user()->id;
        Category::create($requestValidate);
        return redirect('/user/category')->with('success', 'Berhasil menambah kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $title = "Ubah Kategori | POSmart";
        $activelink = "category";
        return view('users.category.edit', compact('title', 'activelink', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $requestValidate = $request->validate([
            'name' => 'required'
        ]);
        $category->update($requestValidate);
        return redirect('/user/category')->with('success', 'Berhasil mengubah kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
