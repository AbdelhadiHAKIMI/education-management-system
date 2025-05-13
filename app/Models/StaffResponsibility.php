<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffResponsibility extends Model
{
    protected $fillable = [
        'staff_id', 'program_id', 'responsibility_id'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function responsibility()
    {
        return $this->belongsTo(Responsibility::class);
    }
}