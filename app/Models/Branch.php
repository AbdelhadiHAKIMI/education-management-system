<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
   protected $fillable = [
      'name',
      'level_id',
   ];

   public function level()
   {
      return $this->belongsTo(Level::class);
   }
}
