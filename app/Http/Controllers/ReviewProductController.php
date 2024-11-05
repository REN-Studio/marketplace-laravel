<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewProductController extends Controller
{
    public function index(Product $product){
        //cara 1
        // $reviews = Review::where("product_id", "=", $product->id)->get();
        //cara 2
        $reviews2 = $product->reviews()->get();
        return response()->json(["data" => $reviews2]);
    }


    public function store(Request $request, Product $product){
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'rating' => 'required|integer|max:5|min:1'
        ], [
            'content.required' => 'Review konten produk wajib diisi.',
            'content.string' => 'Review konten harus berupa string.',
            'content.max' => 'Review konten tidak boleh lebih dari 255 karakter.',
            'rating.required' => 'Rating produk wajib diisi.',
            'rating.integer' => 'Rating produk harus berupa angka.',
            'rating.max' => 'Rating produk tidak bisa melebihi 5',
            'rating.min' => 'Rating produk tidak bisa kurang dari 1',
        ]);
        $review = $product->reviews()->create($validatedData);
        return response()->json([
            "data" => $review
        ]);
    }


    public function destroy(Product $product, Review $review){
        abort_if($product->id !== $review->product_id, 404);
        $review->delete();
        return response()->json([
            "message" => "Review berhasil dihapus"
        ]);
    }
}
