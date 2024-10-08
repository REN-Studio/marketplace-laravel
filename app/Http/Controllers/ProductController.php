<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer'
        ]);
        
        $product = Product::create($validatedData);
        return response()->json(['message' => 'Produk berhasil ditambahkan', 'product' =>$product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product){
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer'
        ]);
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->update($validatedData);
        $updatedProduct = Product::find($id);
        return response()->json(['message' => 'Produk berhasil diupdate', 'product' => $updatedProduct]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
