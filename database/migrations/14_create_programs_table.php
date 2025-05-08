<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::create('programs', function (Blueprint $table) {
         $table->id();
         $table->string('name', 100);
         $table->text('description')->nullable();
         $table->date('start_date');
         $table->date('end_date');
         $table->foreignId('academic_year_id')->constrained('academic_years');
         $table->decimal('registration_fees', 10, 2);
         $table->boolean('is_active')->default(true);
         $table->foreignId('created_by_id')->constrained('users');
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('programs');
   }
};
