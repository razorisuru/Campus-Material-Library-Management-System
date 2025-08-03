<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pdf_access_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'pdf_id',
        'accessed_at',
    ];
}
