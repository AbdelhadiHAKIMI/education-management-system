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
      Schema::create('program_invitations', function (Blueprint $table) {
         $table->id();
         $table->foreignId('student_id')->constrained('students');
         $table->foreignId('program_id')->constrained('programs');
         $table->enum('status', ['invited', 'accepted', 'declined', 'waiting_list'])->default('invited');
         $table->boolean('is_exempt')->default(false);
         $table->timestamp('invited_at')->useCurrent();
         $table->timestamp('responded_at')->nullable();
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('program_invitations');
   }
};
