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
}
