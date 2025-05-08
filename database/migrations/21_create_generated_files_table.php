<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('generated_files', function (Blueprint $table) {
         $table->id();
         $table->string('name', 255);
         $table->text('description')->nullable();
         $table->foreignId('program_id')->constrained('programs');
         $table->foreignId('generated_by_id')->constrained('users');
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('generated_files');
   }
};
