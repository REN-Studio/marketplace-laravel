<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::get();
        return response()->json(['data' => $brands]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama brand produk wajib diisi.',
            'name.string' => 'Nama brand harus berupa string.',
            'name.max' => 'Nama brand tidak boleh lebih dari 20 karakter.',
        ]);
        $brand = Brand::create($validatedData);
        return response()->json(['data' => $brand]);
    }

    public function update(Request $request, Brand $brand){
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama brand produk wajib diisi.',
            'name.string' => 'Nama brand harus berupa string.',
            'name.max' => 'Nama brand tidak boleh lebih dari 20 karakter.',
        ]);
        $brand->update($validatedData);
        return response()->json(['data' => $brand]);
    }

    public function destroy(Brand $brand){
        $brand->delete();
        return response()->json(['message' => 'Brand berhasil dihapus']);
    }
}
