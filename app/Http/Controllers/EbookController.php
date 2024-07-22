<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EBook;
use App\Models\EBookCategory;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = EBook::with('categories')->get(); // Load categories with ebooks
        $ebookCategories = EBookCategory::all(); // Load categories with ebooks
        return view('studentView.ebook', compact(['ebooks', 'ebookCategories']));
    }

    public function UploadView()
    {
        $ebookCategories = EBookCategory::all();
        return view('EBOOK.UploadView', compact(['ebookCategories']));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_date' => 'required|string',
            'isbn' => 'required|string',
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


        // EBook::insert($imageData);

        // if ($request->has('categories')) {
            // $ebook->categories()->attach($request->categories);
            $ebook->categories()->attach([1, 4]);
        // }

        return redirect()->back()->with('status', 'Uploaded Successfully');
    }
}
