<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EBookCategoryJoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'ebook_id',
        'category_id'
    ];
}
