<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    protected $fillable = [
        'staff_id', 'program_id', 'month', 'year', 'daily_base_amount',
        'total_bouneses', 'total_salary', 'status', 'paid_at'
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