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
         $table->string('wilaya', 50)->nullable();
         $table->string('phone', 30)->nullable();
         $table->string('email', 100)->nullable();
         $table->string('logo')->nullable();
         $table->string('registration_code', 50)->unique();
         $table->boolean('is_active')->default(true);
         $table->unsignedBigInteger('created_by')->nullable();
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('establishments');
   }
};
