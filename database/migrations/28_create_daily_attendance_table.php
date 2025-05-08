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
      Schema::create('daily_attendance', function (Blueprint $table) {
         $table->id();
         $table->foreignId('program_invitation_id')->constrained('program_invitations');
         $table->date('attendance_date');
         $table->enum('status', ['present', 'absent', 'excused', 'late']);
         $table->timestamps();
         $table->foreignId('recorded_by_id')->constrained('users');
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('daily_attendance');
   }
};
