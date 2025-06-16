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
        Schema::table('subject_grades', function (Blueprint $table) {
            // Step 1: Drop the foreign key constraint and the exam_result_id column.
            // The foreign key constraint is typically named {table}_{column}_foreign.
            $table->dropForeign(['exam_result_id']);
            $table->dropColumn('exam_result_id');

            // Step 2: Add student_id and exam_session_id columns after the 'id' column.
            // We need to add exam_session_id to maintain the link to a specific exam period,
            // which was previously handled by the exam_results table.
            $table->foreignId('student_id')->after('id')->constrained('students')->onDelete('cascade');
            $table->foreignId('exam_session_id')->after('student_id')->constrained('exam_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_grades', function (Blueprint $table) {
            // Step 1: Drop the newly added foreign keys and columns.
            $table->dropForeign(['student_id']);
            $table->dropForeign(['exam_session_id']);
            $table->dropColumn('student_id');
            $table->dropColumn('exam_session_id');

            // Step 2: Add back the original exam_result_id column and its foreign key constraint.
            // This makes the migration fully reversible.
            $table->foreignId('exam_result_id')->constrained('exam_results')->onDelete('cascade');
        });
    }
};
