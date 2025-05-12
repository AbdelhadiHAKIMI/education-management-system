<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
   // Allow mass assignment for these fields
   protected $fillable = [
      'name',
      'location',
      'logo',
      'registration_code',
      'is_active',
      'created_by',
   ];

   // Relationship: Establishment belongs to User (creator)
   public function creator()
   {
      return $this->belongsTo(User::class, 'created_by');
   }
}
