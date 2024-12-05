<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListSupplierResource;
use App\Models\Supplier;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(){
        $suppliers = Supplier::get();
        return ListSupplierResource::collection($suppliers);
    }
    
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'contact_number' => 'required|string|min:8'
        ], [
            'name.required' => 'Nama brand produk wajib diisi.',
            'name.string' => 'Nama brand harus berupa string.',
            'name.max' => 'Nama brand tidak boleh lebih dari 20 karakter.',
            'contact_number.required' => 'Nomor Kontak harus diisi',
            'contact_number.string' => 'Nomor kontak harus berupa string',
            'contact_number.min' => 'Nomor kontak tidak boleh kurang dari 8 karakter'
        ]);

        $supplier = Supplier::create($validatedData);

        return ListSupplierResource::make($supplier);
    }

    public function update(Request $request, Supplier $supplier){
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'contact_number' => 'required|string|min:8'
        ], [
            'name.required' => 'Nama brand produk wajib diisi.',
            'name.string' => 'Nama brand harus berupa string.',
            'name.max' => 'Nama brand tidak boleh lebih dari 20 karakter.',
            'contact_number.required' => 'Nomor Kontak harus diisi',
            'contact_number.string' => 'Nomor kontak harus berupa string',
            'contact_number.min' => 'Nomor kontak tidak boleh kurang dari 8 karakter'
        ]);

        $supplier->update($validatedData);
        // $supplier->name=$validatedData["name"];
        // $supplier->contact_number=$validatedData["contact_number"];
        // $supplier->save();
        return ListSupplierResource::make($supplier);
    }

    public function destroy(Supplier $supplier){
        $supplier->delete();
        return response()->json(['message'=>'Supplier berasil di hapus']);
    }
}