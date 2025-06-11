<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
   protected $fillable = [
      'full_name',
      'birth_date',
      'phone',
      'bac_year',
      'univ_specialty',
      'type',
      'branch_id',
      'academic_year_id',
      'establishment_id',
   ];

   protected $casts = [
        'birth_date' => 'date', // or 'datetime' if you store time as well
    ];

   public function branch()
   {
      return $this->belongsTo(Branch::class);
   }

   public function academicYear()
   {
      return $this->belongsTo(AcademicYear::class);
   }

   public function establishment()
   {
      return $this->belongsTo(Establishment::class);
   }

   public function programStaff()
   {
      return $this->hasMany(ProgramStaff::class);
   }

   public function responsibilities()
   {
      return $this->hasMany(StaffResponsibility::class);
   }

   public function salaries()
   {
      return $this->hasMany(StaffSalary::class);
   }

   public function specialGrants()
   {
      return $this->hasMany(StaffSpecialGrant::class);
   }

   public function seniority()
   {
      return $this->hasOne(StaffSeniority::class);
   }

   public function performanceGrants()
   {
      return $this->hasMany(StaffPerformanceGrant::class);
   }

   public function subject()
   {
      return $this->belongsTo(Subject::class);
   }

   public function subjects()
   {
      return $this->belongsToMany(Subject::class, 'teacher_subjects', 'teacher_id', 'subject_id');
   }
}
