<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request()->query("limit", 5);
        $keyword = request()->query("keyword", 0);
        $productKeyword = request()->query("product_key", "");
        $urutan = request()->query("urutan", "asc");
        // $products = Product::->paginate($limit);
        $products = Product::with("brand", "category")
            ->where("stock", ">", $keyword)
            ->where("name", "like", "%{$productKeyword}%")
            ->orderBy('name', $urutan)
            ->paginate($limit);

        return ListProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'name' => 'required|string|max:20',
            'price' => 'required|integer',
            'stock' => 'required|integer'
        ], [
            'brand_id.required' => 'Id brand produk wajib diisi.',
            'brand_id.integer' => 'Id brand produk harus berupa integer.',
            'category_id.required' => 'Id category produk wajib diisi.',
            'category_id.integer' => 'Id category produk harus berupa integer.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa string.',
            'name.max' => 'Nama produk tidak boleh lebih dari 20 karakter.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.integer' => 'Harga produk harus berupa angka.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.integer' => 'Stok produk harus berupa angka.',
        ]);
        
        $product = Product::create($validatedData);
        $product->loadMissing("brand", "category");
        
        return ListProductResource::make($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id); 
        return response()->json(['product' => $product]);
        // $product = Product::find($id);

        // if ($product){
        //     return response()->json(['product' => $product]);
        // } else {
        //     return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json(['message' => 'Produk berhasil diupdate'], 200);
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'price' => 'required|integer',
        //     'stock' => 'required|integer'
        // ]);
        // $product = Product::find($id);
        // if (!$product) {
        //     return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        // }

        // $product->update($validatedData);
        // $updatedProduct = Product::find($id);
        // return response()->json(['message' => 'Produk berhasil diupdate', 'product' => $updatedProduct]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
        // $product = Product::find($id);

        // if (!$product) {
        //     return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        // }

        // $product->delete();
        // return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
