<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('student_academic_years', function (Blueprint $table) {
         $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
         $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
         $table->foreignId('level_id')->constrained('levels');
         $table->primary(['student_id', 'academic_year_id']);
      });
   }

   public function down()
   {
      Schema::dropIfExists('student_academic_years');
   }
};
