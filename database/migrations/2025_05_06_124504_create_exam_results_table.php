<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('exam_results', function (Blueprint $table) {
         $table->id();
         $table->foreignId('student_id')->constrained('students');
         $table->foreignId('exam_session_id')->constrained('exam_sessions');
         $table->foreignId('branch_id')->constrained('branches');
         $table->decimal('overall_score', 5, 2);
         $table->enum('success_status', ['passed', 'failed']);
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('exam_results');
   }
};
