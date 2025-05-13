<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    protected $fillable = [
        'program_staff_id', 'attendance_date', 'status', 'recorded_by_id'
    ];

    public function programStaff()
    {
        return $this->belongsTo(ProgramStaff::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by_id');
    }
}