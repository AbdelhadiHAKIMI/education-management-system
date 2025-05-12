<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    protected $fillable = [
        'name', 'academic_year_id', 'semester', 'is_current'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }
}