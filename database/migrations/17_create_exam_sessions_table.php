<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('exam_sessions', function (Blueprint $table) {
         $table->id();
         $table->string('name', 100);
         $table->foreignId('academic_year_id')->constrained('academic_years');
         $table->enum('semester', ['first', 'second']);
         $table->boolean('is_current')->default(false);
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('exam_sessions');
   }
};
