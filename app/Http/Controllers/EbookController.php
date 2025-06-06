<?php

namespace App\Http\Controllers;

use App\Models\EBook;
use Illuminate\Http\Request;
use App\Models\EBookCategory;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = EBook::with('categories')
            ->get()
            ->map(function ($ebooks) {
                $ebooks->file_size_formatted = $this->formatBytes($ebooks->file_size);
                return $ebooks;
            });
        ; // Load categories with ebooks
        $ebookCategories = EBookCategory::all(); // Load categories with ebooks
        return view('studentDashboard.ebook', compact(['ebooks', 'ebookCategories']));
        // return($ebookCategories);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function ai()
    {

        return view('studentView.ai');
    }

    public function UploadView()
    {
        $ebooks = EBook::with('categories')->get(); // Load categories with ebooks
        $ebookCategories = EBookCategory::all();
        return view('EBOOK.UploadView', compact(['ebooks', 'ebookCategories']));
    }

    public function ManageView()
    {
        $ebooks = EBook::with('categories')->get(); // Load categories with ebooks
        $ebookCategories = EBookCategory::all(); // Load categories with ebooks
        return view('EBOOK.ManageView', compact(['ebooks', 'ebookCategories']));
    }

    public function EditView($id)
    {
        $ebook = EBook::with('categories')->findOrFail($id);
        $ebookCategories = EBookCategory::all(); // Load categories with ebooks
        return view('EBOOK.EditView', compact(['ebook', 'ebookCategories']));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_date' => 'required|string',
            'isbn' => 'required|string|unique:e_books,isbn',

            'ebookcategories' => 'required|array', // Validate categories as an array
            'ebookcategories.*' => 'required|exists:e_book_categories,id', // Ensure each category exists

            'cover_image' => 'required|mimes:png,jpg,jpeg|max:51200',
            'ebook_file' => 'required|mimes:pdf,docx|max:51200',

        ]);


        $cover_image = $request->file('cover_image');
        $ebook_file = $request->file('ebook_file');
        // $extension = $file->getClientOriginalExtension();
        $cover_image_filename = $cover_image->getClientOriginalName();
        $ebook_file_filename = $ebook_file->getClientOriginalName();
        $cover_image_path = "uploads/ebooks-cover/";
        $ebook_file_path = "uploads/ebooks/";
        $cover_image->storeAs('public', $cover_image_path . $cover_image_filename);
        $ebook_file->storeAs('public', $ebook_file_path . $ebook_file_filename);

        $ebook = Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'publication_date' => $request->publication_date,
            'isbn' => $request->isbn,
            'cover_image' => $cover_image_path . $cover_image_filename,
            'file_path' => $ebook_file_path . $ebook_file_filename,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->has('ebookcategories')) {
            $ebook->categories()->attach($request->input('ebookcategories'));
        }

        // EBook::insert($imageData);

        // if ($request->has('categories')) {
        // $ebook->categories()->attach($request->categories);
        // $ebook->categories()->attach([1, 4]);
        // }

        return redirect()->back()->with('status', 'Uploaded Successfully');
    }

    public function update(Request $request, $id)
    {
        $ebook = Ebook::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_date' => 'required|string',
            'isbn' => 'required|string',

            'ebookcategories' => 'required|array', // Validate categories as an array
            'ebookcategories.*' => 'required|exists:e_book_categories,id', // Ensure each category exists

            'cover_image' => 'nullable|mimes:png,jpg,jpeg|max:51200',
            'ebook_file' => 'nullable|mimes:pdf,docx|max:51200',
        ]);

        $cover_image_filename = $ebook->cover_image;
        $ebook_file_filename = $ebook->file_path;
        $cover_image_path = "";
        $ebook_file_path = "";

        if ($request->hasFile('cover_image')) {
            Storage::delete('public/' . $ebook->cover_image);
            $cover_image = $request->file('cover_image');
            $cover_image_filename = $cover_image->getClientOriginalName();
            $cover_image_path = "uploads/ebooks-cover/";
            $cover_image->storeAs('public', $cover_image_path . $cover_image_filename);
        } else {
            $cover_image_path = "";
        }

        if ($request->hasFile('ebook_file')) {
            Storage::delete('public/' . $ebook->file_path);
            $ebook_file = $request->file('ebook_file');
            $ebook_file_filename = $ebook_file->getClientOriginalName();
            $ebook_file_path = "uploads/ebooks/";
            $ebook_file->storeAs('public', $ebook_file_path . $ebook_file_filename);
        } else {
            $ebook_file_path = "";
        }

        $ebook->update([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'publication_date' => $request->publication_date,
            'isbn' => $request->isbn,
            'cover_image' => $cover_image_path . $cover_image_filename,
            'file_path' => $ebook_file_path . $ebook_file_filename,
            'updated_at' => now(),
        ]);

        $ebook->categories()->sync($request->input('ebookcategories', []));

        return redirect()->back()->with('status', 'Updated Successfully');
    }


    public function destroy($id)
    {
        $ebook = EBook::findOrFail($id);

        Storage::delete('public/' . $ebook->file_path);
        Storage::delete('public/' . $ebook->cover_image);
        $ebook->delete();
        return redirect()->back()->with('status', 'File Deleted Successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            // Fetch the EBook records to get the file paths
            $ebooks = EBook::whereIn('id', $ids)->get();

            // Loop through the records and delete the associated files
            foreach ($ebooks as $ebook) {
                if ($ebook->file_path) {
                    Storage::delete('public/' . $ebook->file_path);
                }
                if ($ebook->cover_image) {
                    Storage::delete('public/' . $ebook->cover_image);
                }
            }

            // Now delete the records from the database
            EBook::whereIn('id', $ids)->delete();

            return response()->json(['message' => 'EBooks and associated files deleted successfully!']);
        }

        return response()->json(['message' => 'No items selected!'], 400);
    }


}
