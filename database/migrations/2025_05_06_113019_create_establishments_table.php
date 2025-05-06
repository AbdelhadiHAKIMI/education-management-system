<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('establishments', function (Blueprint $table) {
         $table->id();
         $table->string('name', 100);
         $table->string('location')->nullable();
         $table->string('logo')->nullable();
         $table->string('registration_code', 50)->unique();
         $table->boolean('is_active')->default(true);
         $table->string('created_by', 50);
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('establishments');
   }
};
