<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'logo',
        'registration_code',
        'is_active',
    ];

    // Relationships
    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }
}