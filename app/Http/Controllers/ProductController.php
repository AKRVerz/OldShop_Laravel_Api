<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->inventory = $request->input('inventory', 0); // Default inventory is 0
            $product->save();

            return response()->json($product, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create product: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->inventory = $request->input('inventory');
            $product->save();

            return response()->json($product);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to update product: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }
}
