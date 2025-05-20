<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
   protected $fillable = [
      'name',
      'level_id',
   ];

   public function level(): BelongsTo
   {
      return $this->belongsTo(Level::class);
   }

   // If you need to access academic year through level
   public function academicYear()
   {
      return $this->level->academicYear();
   }
}
