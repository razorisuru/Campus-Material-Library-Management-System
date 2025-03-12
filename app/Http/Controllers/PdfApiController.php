<?php

namespace App\Http\Controllers;

use App\Models\EBook;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\EBookCategory;
use App\Models\DegreeProgramme;

class PdfApiController extends Controller
{
    public function degreeCategory() {
        $degreeProgrammes = DegreeProgramme::all();
        return response()->json($degreeProgrammes);
    }

    public function pdfCategory() {
        $pdfCategory = Category::all();
        return response()->json($pdfCategory);
    }

    public function ebookCategory() {
        $ebookCategory = EBookCategory::all();
        return response()->json($ebookCategory);
    }

    public function ebooks() {
        $ebooks = EBook::with('categories')->get();
        return response()->json($ebooks);
    }

    public function ebook($id) {
        $ebooks = EBook::with('categories')->findOrFail($id);
        return response()->json($ebooks);
    }
}
