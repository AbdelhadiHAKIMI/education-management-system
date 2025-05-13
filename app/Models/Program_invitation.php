<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Program_invitation extends Model
{
    use HasFactory;
    protected $table = 'program_invitations';

    protected $fillable = [
        'student_id',
        'program_id',
        'status',
        'is_exempt',
        'invited_at',
        'responded_at',
    ];

    protected $casts = [
        'is_exempt' => 'boolean',
        'invited_at' => 'datetime',
        'responded_at' => 'datetime',
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