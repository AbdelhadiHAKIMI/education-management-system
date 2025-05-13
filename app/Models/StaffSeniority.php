<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSeniority extends Model
{
    protected $table = 'staff_seniority';
    public $timestamps = true;
    protected $primaryKey = 'staff_id';
    public $incrementing = false;

    protected $fillable = [
        'staff_id', 'points'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}