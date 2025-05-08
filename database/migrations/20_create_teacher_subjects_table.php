<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('teacher_subjects', function (Blueprint $table) {
         $table->id();
         $table->foreignId('teacher_id')->constrained('staff')->onDelete('cascade');
         $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
      });
   }

   public function down()
   {
      Schema::dropIfExists('teacher_subjects');
   }
};
