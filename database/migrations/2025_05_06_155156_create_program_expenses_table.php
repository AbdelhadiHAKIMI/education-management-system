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
      Schema::create('program_expenses', function (Blueprint $table) {
         $table->id();
         $table->foreignId('program_id')->constrained('programs');
         $table->date('expense_date');
         $table->decimal('amount', 10, 2);
         $table->string('description');
         $table->foreignId('received_by_id')->constrained('staff');
         $table->foreignId('recorded_by_id')->constrained('users');
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('program_expenses');
   }
};
