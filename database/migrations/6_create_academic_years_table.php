<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('academic_years', function (Blueprint $table) {
         $table->id();
         $table->string('name', 50);
         $table->date('start_date');
         $table->date('end_date');
         $table->foreignId('establishment_id')->constrained('establishments');
         $table->boolean('status')->default(false); // <-- change to boolean
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('academic_years');
   }
};
