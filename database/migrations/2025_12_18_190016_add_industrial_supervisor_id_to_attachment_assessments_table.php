<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // Inside the migration file:
public function up()
{
    Schema::table('attachment_assessments', function (Blueprint $table) {
        $table->unsignedBigInteger('industrial_supervisor_id')->nullable()->after('attachment_student_id');
        // Add foreign key if you have industrial_supervisors table
        // $table->foreign('industrial_supervisor_id')->references('id')->on('industrial_supervisors')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('attachment_assessments', function (Blueprint $table) {
        $table->dropColumn('industrial_supervisor_id');
        // $table->dropForeign(['industrial_supervisor_id']);
    });
}
};
