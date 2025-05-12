<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'student_id', 'exam_session_id', 'branch_id', 'overall_score', 'success_status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examSession()
    {
        return $this->belongsTo(ExamSession::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function subjectGrades()
    {
        return $this->hasMany(SubjectGrade::class);
    }
}