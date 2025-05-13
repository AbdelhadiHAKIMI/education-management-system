<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
   // Allow mass assignment for these fields
   protected $fillable = [
      'name',
      'academic_year_id',
   ];

   // Relationship: Level belongs to AcademicYear
   public function academicYear()
   {
      return $this->belongsTo(AcademicYear::class);
   }
}

