<?php

namespace App\Http\Controllers;

use App\Models\EBook;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    public function index()
    {
        $ebooks = EBook::all();
        return view('studentView.ebook', compact('ebooks'));
    }
}
