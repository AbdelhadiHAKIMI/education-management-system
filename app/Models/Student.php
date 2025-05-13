<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{

    protected $fillable = [
        'full_name',
        'birth_date',
        'origin_school',
        'health_conditions',
        'parent_phone',
        'student_phone',
        'quran_level',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}