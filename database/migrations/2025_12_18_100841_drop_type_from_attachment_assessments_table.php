<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            // Drop unique index first if it exists
            $table->dropUnique(['attachment_student_id', 'type']);
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            $table->string('type')->after('attachment_student_id');
            $table->unique(['attachment_student_id', 'type']);
        });
    }
};
