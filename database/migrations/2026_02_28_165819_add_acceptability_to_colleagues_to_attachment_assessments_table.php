<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
         
            $table->unsignedTinyInteger('acceptability_to_colleagues_marks')->default(0)->after('effective_time_use_marks');
            $table->text('acceptability_to_colleagues_remarks')->nullable()->after('acceptability_to_colleagues_marks');
        });
    }

    public function down(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            
            $table->dropColumn(['acceptability_to_colleagues_marks', 'acceptability_to_colleagues_remarks']);
        });
    }
};