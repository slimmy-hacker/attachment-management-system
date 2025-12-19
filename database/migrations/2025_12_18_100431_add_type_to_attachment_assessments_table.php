<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            $table->string('type')->after('attachment_student_id');
            $table->unique(['attachment_student_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            $table->dropUnique(['attachment_student_id', 'type']);
            $table->dropColumn('type');
        });
    }
};
