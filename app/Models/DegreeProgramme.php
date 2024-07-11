<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeProgramme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class, 'uploaded_by');
    }
}
