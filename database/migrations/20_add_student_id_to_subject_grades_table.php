<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subject_grades', function (Blueprint $table) {
            if (!Schema::hasColumn('subject_grades', 'coefficient')) {
                $table->integer('coefficient')->nullable()->after('grade');
            }
        });
    }

    public function down()
    {
        Schema::table('subject_grades', function (Blueprint $table) {
            if (Schema::hasColumn('subject_grades', 'coefficient')) {
                $table->dropColumn('coefficient');
            }
        });
    }
};
