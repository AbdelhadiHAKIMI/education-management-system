<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('students', function (Blueprint $table) {
         $table->id();
         $table->string('full_name', 100);
         $table->date('birth_date');
         $table->string('origin_school')->nullable();
         $table->text('health_conditions')->nullable();
         $table->string('parent_phone', 20)->nullable();
         $table->string('student_phone', 20)->nullable();
         $table->enum('quran_level', ['مستظهر', 'خاتم'])->nullable();
         $table->foreignId('branch_id')->constrained('branches');
         // No level_id here
         $table->string('initial_classroom')->nullable();
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('students');
   }
};
