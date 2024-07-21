<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'publication_date',
        'isbn',
        'cover_image',
        'file_path'
    ];

    public function categories()
    {
        return $this->belongsToMany(EBookCategory::class, 'e_book_category_joins', 'ebook_id', 'category_id');
    }
}
