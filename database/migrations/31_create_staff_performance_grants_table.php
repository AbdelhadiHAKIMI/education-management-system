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
      Schema::create('staff_performance_grants', function (Blueprint $table) {
         $table->id();
         $table->foreignId('staff_id')->constrained('staff');
         $table->foreignId('program_id')->constrained();
         $table->unsignedSmallInteger('initial_points');
         $table->unsignedSmallInteger('achieved_points');
         $table->decimal('grant_value', 10, 2);
         $table->timestamps();
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_performance_grants');
    }
};
