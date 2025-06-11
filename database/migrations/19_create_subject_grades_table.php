<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('subject_grades', function (Blueprint $table) {
         $table->id();
         $table->foreignId('exam_result_id')->constrained('exam_results')->onDelete('cascade');
         $table->string('subject');
         $table->decimal('grade', 5, 2)->nullable();
         $table->integer('coefficient')->nullable();
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('subject_grades');
   }
};
