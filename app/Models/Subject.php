<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'degree_programme_id',
        'subject_code',
        'name',
        'description',
    ];

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function degreeProgramme()
    {
        return $this->belongsTo(DegreeProgramme::class);
    }

    // public function learningMaterials()
    // {
    //     return $this->hasMany(LearningMaterials::class);
    // }
}
