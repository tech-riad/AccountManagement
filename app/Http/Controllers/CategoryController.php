<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()

    {

        $category = Category::all();
        return view('backend.category.index',compact('category'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|in:income,expense',
        ]);

        $category = new Category();
        $category->category_name = $validatedData['category_name'];
        $category->slug          = Str::slug($category->category_name);
        $category->category_type = $validatedData['category_type'];
        $category->save();


        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }




    public function update(Request $request, Category $category)
    {

        $request->validate([
            'category_name' => 'required|string',
            'category_type' => 'required|in:income,expense',
        ]);


        $category->update([
            'category_name' => $request->input('category_name'),
            'slug'          => Str::slug($request->input('category_name')),
            'category_type' => $request->input('category_type'),
        ]);



        return response()->json(['message' => 'Category updated successfully']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

}
