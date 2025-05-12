<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectGrade extends Model
{
    protected $fillable = [
        'exam_result_id', 'subject_id', 'grade'
    ];

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}