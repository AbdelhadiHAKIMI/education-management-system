<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStaff extends Model
{
    protected $fillable = [
        'program_id', 'assigned_at', 'is_active', 'staff_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}