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
      Schema::create('student_payments', function (Blueprint $table) {
         $table->id();
         $table->foreignId('program_invitation_id')->constrained('program_invitations');
         $table->decimal('amount', 10, 2);
         $table->date('payment_date');
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('student_payments');
   }
};
