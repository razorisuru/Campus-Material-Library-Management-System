<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'description',
        'file_path',
        'uploaded_by',
        'status',
    ];

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
