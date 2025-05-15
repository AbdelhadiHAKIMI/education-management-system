<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Level extends Model
{
   // Allow mass assignment for these fields
   protected $fillable = [
      'name',
      'academic_year_id',
   ];

   // Relationship: Level belongs to AcademicYear

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
