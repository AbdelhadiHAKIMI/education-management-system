<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'establishment_id',
    ];

    // Relationships
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}