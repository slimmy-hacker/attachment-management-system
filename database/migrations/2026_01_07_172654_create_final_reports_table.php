<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('final_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('attachment_student_id')->constrained()->cascadeOnDelete();
        $table->string('title');
        $table->text('content')->nullable();
        $table->string('file_path');
        $table->boolean('is_submitted')->default(true);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_reports');
    }
};
