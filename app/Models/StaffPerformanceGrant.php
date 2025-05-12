<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPerformanceGrant extends Model
{
    protected $fillable = [
        'staff_id', 'program_id', 'initial_points', 'achieved_points', 'grant_value'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}