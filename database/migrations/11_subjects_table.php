<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('subjects', function (Blueprint $table) {
         $table->id();
         $table->string('name', 100);
         $table->decimal('coefficient', 3, 1);
         $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
         $table->boolean('is_core_subject')->default(false);
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('subjects');
   }
};
