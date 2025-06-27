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

   public function subjects()
   {
      return $this->hasMany(Subject::class);
   }
}
