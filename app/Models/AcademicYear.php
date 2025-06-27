<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{

   // Mass assignable attributes
   protected $fillable = [
      'name',
      'start_date',
      'end_date',
      'establishment_id',
      'status', // boolean
   ];

   // Relationship: AcademicYear belongs to Establishment
   public function establishment()
   {
      return $this->belongsTo(Establishment::class);
   }

   public function examSessions()
   {
      return $this->hasMany(\App\Models\ExamSession::class);
   }

   protected static function booted()
   {
      // REMOVE exam session creation from here!
      static::deleting(function ($academicYear) {
         $academicYear->examSessions()->delete();
      });
   }

   // Add this helper as a static method in the AcademicYear model
   public static function ensureExamSessionsForAllYears()
   {
      $sessions = [
         ['name' => 'الفصل الأول', 'semester' => 'first'],
         ['name' => 'الفصل الثاني', 'semester' => 'second'],
         ['name' => 'الفصل الثالث', 'semester' => 'third'],
      ];
      foreach (self::all() as $year) {
         // Only create if there are no sessions for this year
         if ($year->examSessions()->count() == 0) {
            foreach ($sessions as $session) {
               \App\Models\ExamSession::create([
                  'name' => $session['name'],
                  'academic_year_id' => $year->id,
                  'semester' => $session['semester'],
                  'is_current' => false,
               ]);
            }
         }
      }
   }
}
