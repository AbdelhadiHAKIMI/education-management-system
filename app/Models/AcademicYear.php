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
   ];

   // Relationship: AcademicYear belongs to Establishment
   public function establishment()
   {
      return $this->belongsTo(Establishment::class);
   }
}

