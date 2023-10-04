<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()

    {
        $product = Product::all();
        return view('backend.product.index',compact('product'));
    }

        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
            ]);

            $product = new Product();
            $product->product_name = $validatedData['product_name'];
            $product->slug         = Str::slug($product->product_name);
            $product->save();

            return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
        }

        public function update(Request $request, Product $product)
        {
            try {
                $request->validate([
                    'product_name' => 'required|string|max:255',
                ]);

                // Update product data
                $product->product_name = $request->input('product_name');
                $product->slug         = Str::slug($request->input('product_name'));
                $product->save();

                return response()->json(['message' => 'Product updated successfully']);
            } catch (\Exception $e) {
                return response()->json(['error'   => 'An error occurred while updating the product.'], 500);
            }
        }

        public function destroy(Product $product)
        {
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);
        }


}
