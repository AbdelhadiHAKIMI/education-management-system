<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('staff_attendance', function (Blueprint $table) {
         $table->id();
         $table->foreignId('program_staff_id')->constrained('program_staff');
         $table->date('attendance_date');
         $table->enum('status', ['present', 'absent']);
         $table->foreignId('recorded_by_id')->constrained('users');
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('staff_attendance');
   }
};
