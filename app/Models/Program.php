<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
   protected $table = 'programs';

   protected $fillable = [
      'name',
      'description',
      'start_date',
      'end_date',
      'academic_year_id',
      'level_id',
      'registration_fees',
      'is_active',
      'created_by_id'
   ];

   public function academicYear()
   {
      return $this->belongsTo(AcademicYear::class);
   }

   public function creator()
   {
      return $this->belongsTo(User::class, 'created_by_id');
   }

   public function level()
   {
      return $this->belongsTo(Level::class);
   }

   public function invitations()
   {
      return $this->hasMany(\App\Models\ProgramInvitation::class, 'program_id');
   }
}
