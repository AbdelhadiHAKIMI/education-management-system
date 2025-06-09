<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->boolean('status')->default(false)->change();
        });
    }

    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('inactive')->change();
        });
    }
};
