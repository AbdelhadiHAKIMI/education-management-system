<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subject_grades', function (Blueprint $table) {
            // Add 'coefficient' if missing
            if (!Schema::hasColumn('subject_grades', 'coefficient')) {
                $table->integer('coefficient')->nullable()->after('grade');
            }
            // You do NOT need to add 'subject' if you already have 'subject_id'
            // Remove or comment out the following block if not needed:
            // if (!Schema::hasColumn('subject_grades', 'subject')) {
            //     $table->string('subject')->nullable()->after('coefficient');
            // }
        });
    }

    public function down()
    {
        Schema::table('subject_grades', function (Blueprint $table) {
            if (Schema::hasColumn('subject_grades', 'subject')) {
                $table->dropColumn('subject');
            }
            if (Schema::hasColumn('subject_grades', 'coefficient')) {
                $table->dropColumn('coefficient');
            }
        });
    }
};
