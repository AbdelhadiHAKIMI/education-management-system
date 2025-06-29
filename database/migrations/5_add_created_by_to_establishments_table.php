<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      Schema::table('establishments', function (Blueprint $table) {
         $table->unsignedBigInteger('created_by');
         $table->foreign('created_by')->references('id')->on('users');
      });
   }

   public function down()
   {
      Schema::table('establishments', function (Blueprint $table) {
         $table->dropForeign(['created_by']);
      });
   }
};
