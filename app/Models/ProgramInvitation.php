<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramInvitation extends Model
{
    protected $fillable = [
        'student_id', 'program_id', 'status', 'is_exempt', 'invited_at', 'responded_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}