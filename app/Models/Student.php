<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   // Mass assignable attributes
   protected $fillable = [
      'full_name',
      'birth_date',
      'origin_school',
      'health_conditions',
      'parent_phone',
      'student_phone',
      'quran_level',
      'branch_id',
      'initial_classroom',
      'level_id', // <-- use this
      'academic_year_id', // <-- add this
   ];

   // Relationship: Student belongs to Branch
   public function branch()
   {
      return $this->belongsTo(Branch::class);
   }

   // Relationship: Student belongs to Level
   public function level()
   {
      return $this->belongsTo(Level::class);
   }
}
