<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
Schema::table('exam_sessions', function (Blueprint $table) {
$table->dropForeign(['academic_year_id']);
$table->foreign('academic_year_id')
->references('id')->on('academic_years')
->onDelete('cascade');
});
}
public function down()
{
Schema::table('exam_sessions', function (Blueprint $table) {
$table->dropForeign(['academic_year_id']);
$table->foreign('academic_year_id')
->references('id')->on('academic_years');
});
}
};
