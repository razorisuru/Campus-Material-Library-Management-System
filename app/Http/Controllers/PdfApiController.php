<?php

namespace App\Http\Controllers;

use App\Models\EBook;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\EBookCategory;
use App\Models\DegreeProgramme;
use App\Models\LearningMaterial;

class PdfApiController extends Controller
{
    public function degreeCategory()
    {
        $degreeProgrammes = DegreeProgramme::all();
        return response()->json($degreeProgrammes);
    }

    public function pdfCategory()
    {
        $pdfCategory = Category::all();
        return response()->json($pdfCategory);
    }

    public function ebookCategory()
    {
        $ebookCategory = EBookCategory::all();
        return response()->json($ebookCategory);
    }

    public function ebooks()
    {
        $ebooks = EBook::with('categories')
            ->get()
            ->map(function ($ebooks) {
                $ebooks->file_size_formatted = $this->formatBytes($ebooks->file_size);
                return $ebooks;
            });
        ; // Load categories with ebooks
        return response()->json($ebooks);
    }

    public function ebook($id)
    {
        $ebooks = EBook::with('categories')->findOrFail($id);
        return response()->json($ebooks);
    }


    public function pdf(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $page = $request->query('page', 1);

        $materials = LearningMaterial::with(['subjects', 'user', 'category', 'degree'])
            ->where('status', '=', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Format file sizes
        $materials->through(function ($material) {
            $material->file_size_formatted = $this->formatBytes($material->file_size);
            return $material;
        });

        return response()->json($materials);
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
}
