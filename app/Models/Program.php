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
      'created_by_id',
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

   public function programStaff()
   {
      return $this->hasMany(\App\Models\ProgramStaff::class, 'program_id');
   }

   public function supervisors()
   {
      return $this->programStaff()->whereHas('staff', function ($q) {
         $q->where('type', 'مؤطر دراسي');
      })->with('staff');
   }

   public function teachers()
   {
      return $this->programStaff()->whereHas('staff', function ($q) {
         $q->where('type', 'أستاذ');
      })->with('staff');
   }

   public function admins()
   {
      return $this->programStaff()->whereHas('staff', function ($q) {
         $q->where('type', 'إداري');
      })->with('staff');
   }
}
