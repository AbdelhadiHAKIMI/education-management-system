<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->string('wilaya', 50)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn(['wilaya', 'phone', 'email']);
        });
    }
};
