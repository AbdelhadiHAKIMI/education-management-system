<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    */
   public function up(): void
   {
      Schema::table('students', function (Blueprint $table) {
         // Add the establishment_id column
         $table->foreignId('establishment_id')
            ->nullable() // Make it nullable if students can exist without an establishment initially
            ->constrained('establishments') // Assumes your establishments table is named 'establishments'
            ->onDelete('cascade'); // When an establishment is deleted, associated students are also deleted
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::table('students', function (Blueprint $table) {
         // Drop the foreign key constraint first
         $table->dropConstrainedForeignId('establishment_id');
         // Then drop the column
         $table->dropColumn('establishment_id');
      });
   }
};
