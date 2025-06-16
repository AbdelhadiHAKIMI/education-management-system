<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('levels', function (Blueprint $table) {
         // Drop the foreign key constraint first to avoid errors.
         // The convention for the foreign key name is 'table_column_foreign'.
         $table->dropForeign(['academic_year_id']);

         // Now, drop the column itself.
         $table->dropColumn('academic_year_id');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('levels', function (Blueprint $table) {
         // Add the column back. We'll add it after the 'name' column.
         $table->unsignedBigInteger('academic_year_id')->after('name');

         // Re-create the foreign key constraint.
         $table->foreign('academic_year_id')
            ->references('id')
            ->on('academic_years')
            ->onDelete('cascade');
      });
   }
};
