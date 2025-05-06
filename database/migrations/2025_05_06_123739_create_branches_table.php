<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('branches', function (Blueprint $table) {
         $table->id();
         $table->string('name', 50);
         $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('branches');
   }
};
