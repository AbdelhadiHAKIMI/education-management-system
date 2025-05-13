<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAcademicYear extends Model
{
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'student_id', 'academic_year_id', 'level_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}