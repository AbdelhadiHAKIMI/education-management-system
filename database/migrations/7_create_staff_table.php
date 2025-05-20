<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('staff', function (Blueprint $table) {
         $table->id();
         $table->string('full_name', 100);
         $table->date('birth_date');
         $table->string('phone', 20)->nullable();
         $table->integer('bac_year')->nullable();
         $table->string('univ_specialty', 50)->nullable();
         $table->foreignId('academic_year_id')->constrained('academic_years');
         $table->foreignId('establishment_id')->constrained('establishments');
         $table->foreignId('branch_id')->constrained('branches');
      });
    
   }

   public function down()
   {
      Schema::dropIfExists('staff');
   }
};
