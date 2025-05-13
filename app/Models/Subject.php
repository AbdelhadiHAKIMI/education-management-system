<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name', 'coefficient', 'branch_id', 'is_core_subject'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }
}