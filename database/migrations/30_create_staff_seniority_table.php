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
      Schema::create('staff_seniority', function (Blueprint $table) {
         $table->foreignId('staff_id')->constrained('staff')->primary();
         $table->unsignedTinyInteger('points')->default(0); // 0-15 range
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('staff_seniority');
   }
};
