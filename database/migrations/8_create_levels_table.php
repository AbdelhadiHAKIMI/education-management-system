<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('levels', function (Blueprint $table) {
         $table->id();
         $table->string('name', 50);
         $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('levels');
   }
};
