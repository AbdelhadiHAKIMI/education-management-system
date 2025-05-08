<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('program_staff', function (Blueprint $table) {
         $table->id();
         $table->foreignId('program_id')->constrained('programs');
         $table->timestamp('assigned_at')->useCurrent();
         $table->boolean('is_active')->default(true);
         $table->foreignId('staff_id')->constrained('staff');
      });
   }

   public function down()
   {
      Schema::dropIfExists('program_staff');
   }
};
