<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSpecialGrant extends Model
{
    protected $fillable = [
        'program_id', 'amount', 'reason', 'staff_id'
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