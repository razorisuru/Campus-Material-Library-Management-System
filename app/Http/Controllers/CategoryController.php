<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('PDFcategory.view', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'category_name' => 'required|string|max:255',

        ]);

        Category::insert(['name' => $request->category_name]);

        return redirect()->back()->with('status', 'Category Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function destroy($id)
    {
        // Find the file record in the database
        $category = Category::findOrFail($id);



        // Delete the database record
        $category->delete();


        return redirect()->back()->with('status', 'Category Deleted Successfully');
    }
}
