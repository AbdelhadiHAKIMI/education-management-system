<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('inactive')->after('establishment_id');
            // MySQL does not support partial unique indexes, so this is for reference only:
            // $table->unique(['establishment_id', 'status'], 'one_active_year_per_establishment');
        });
    }

    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn('status');
            // $table->dropUnique('one_active_year_per_establishment');
        });
    }
};
