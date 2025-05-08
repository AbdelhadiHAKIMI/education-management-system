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
      Schema::create('staff_salaries', function (Blueprint $table) {
         $table->id();
         $table->foreignId('staff_id')->constrained('staff');
         $table->foreignId('program_id')->constrained();
         $table->tinyInteger('month');
         $table->smallInteger('year');
         $table->decimal('daily_base_amount', 10, 2);
         $table->decimal('total_bouneses', 10, 2);
         $table->decimal('total_salary', 10, 2);
         $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
         $table->timestamp('paid_at')->nullable();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('staff_salaries');
   }
};
