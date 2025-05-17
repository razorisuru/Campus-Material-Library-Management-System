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
        'category_id',
    ];

    protected $appends = ['file_size'];

    public function getFileSizeAttribute()
    {
        $path = ('storage/' . $this->file_path);
        return file_exists($path) ? filesize($path) : 0;
    }

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

    public function degree()
    {
        return $this->hasOneThrough(
            DegreeProgramme::class,
            Subject::class,
            'id', // Foreign key on Subject table
            'id', // Foreign key on DegreeProgramme table
            'subject_id', // Local key on LearningMaterial table
            'degree_programme_id' // Local key on Subject table
        );
    }
}
