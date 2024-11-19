<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:8',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa string.',
            'name.max' => 'Nama produk tidak boleh lebih dari 8 karakter.',
        ]);
        $category = Category::create($validatedData);
        return response()->json([
            'data' => $category
        ]);
    }

    public function index(){
        $categories = Category::get();
        return response()->json(['data' => $categories]);
    }

    public function update(Request $request, Category $category){
        $validatedData = $request->validate([
            'name' => 'required|string|max:8',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa string.',
            'name.max' => 'Nama produk tidak boleh lebih dari 8 karakter.',
        ]);
        $category->update($validatedData);
        return response()->json([
            'data' => $category
        ]);
    }

    public function destroy(Category $category){
        $category->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
