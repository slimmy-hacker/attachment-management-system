<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            $table->unsignedInteger('lecturer_total')->nullable()->after('effective_time_use_remarks');
            $table->unsignedInteger('industrial_total')->nullable()->after('lecturer_total');
            $table->unsignedInteger('final_total')->nullable()->after('industrial_total');
        });
    }

    public function down(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            $table->dropColumn([
                'lecturer_total',
                'industrial_total',
                'final_total',
            ]);
        });
    }
};


