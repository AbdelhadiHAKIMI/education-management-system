<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    */
   public function up(): void
   {
      Schema::create('staff_responsibilities', function (Blueprint $table) {
         $table->id();
         $table->foreignId('staff_id')->constrained('staff');
         $table->foreignId('program_id')->constrained('programs');
         $table->foreignId('responsibility_id')->constrained('responsibilities');
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('staff_responsibilities');
   }
};
