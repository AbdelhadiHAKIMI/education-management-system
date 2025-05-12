<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
        $table->foreignId('level_id')
              ->nullable()
              ->after('academic_year_id')
              ->constrained('levels')
              ->nullOnDelete();
    });
    }

    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropColumn('level_id');
        });
    }
};