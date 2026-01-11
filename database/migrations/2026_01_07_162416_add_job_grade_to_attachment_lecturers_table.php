<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attachment_lecturers', function (Blueprint $table) {
            $table->string('job_grade')->after('lecturer_id');
        });
    }

    public function down(): void
    {
        Schema::table('attachment_lecturers', function (Blueprint $table) {
            $table->dropColumn('job_grade');
        });
    }
};
