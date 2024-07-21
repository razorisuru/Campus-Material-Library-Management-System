<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EBookCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function ebooks()
    {
        return $this->belongsToMany(EBook::class, 'ebook_category', 'category_id', 'ebook_id');
    }
}
