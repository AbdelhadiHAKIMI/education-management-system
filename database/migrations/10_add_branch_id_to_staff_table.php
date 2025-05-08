<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::table('staff', function (Blueprint $table) {
         // Add the column (nullable in case some staff aren't assigned to branches)
         $table->foreignId('branch_id')
            ->nullable()
            ->after('bac_year')  // Place it after the bac_year column
            ->constrained('branches')
            ->nullOnDelete();  // Set to null if branch is deleted
      });
   }

   public function down()
   {
      Schema::table('staff', function (Blueprint $table) {
         // Drop the foreign key first
         $table->dropForeign(['branch_id']);
         // Then drop the column
         $table->dropColumn('branch_id');
      });
   }
};
