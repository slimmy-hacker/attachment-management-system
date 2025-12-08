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
        Schema::create('attachment_lecturers', function (Blueprint $table) {

            $table->id();
            $table->integer('lecturer_id');
            $table->integer('attachment_id');
            $table->integer('department_id');
            $table->timestamps();
            $table->softDeletes();

            // Short unique index name to avoid MySQL 1059 error
            $table->unique(
                ['lecturer_id', 'attachment_id', 'department_id'],
                'att_lec_att_dept_uq'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_lecturers');
    }
};
