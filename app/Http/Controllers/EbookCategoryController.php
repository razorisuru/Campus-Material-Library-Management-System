<?php

namespace App\Http\Controllers;

use App\Models\EBookCategory;
use Illuminate\Http\Request;

class EbookCategoryController extends Controller
{
    public function index()
    {
        $categories = EBookCategory::all();
        return view('EbookCategory.view', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'category_name' => 'required|string|max:255',

        ]);

        EBookCategory::insert(['name' => $request->category_name]);

        return redirect()->back()->with('status', 'Category Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = EBookCategory::find($id);
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
        $category = EBookCategory::findOrFail($id);



        // Delete the database record
        $category->delete();


        return redirect()->back()->with('status', 'Category Deleted Successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            EBookCategory::whereIn('id', $ids)->delete();

            return response()->json(['message' => 'Categories deleted successfully!']);
        }

        return response()->json(['message' => 'No items selected!'], 400);
    }

}
