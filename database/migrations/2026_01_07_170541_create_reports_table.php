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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();

        // Link to attachment student record
        $table->foreignId('attachment_student_id')
              ->constrained()
              ->cascadeOnDelete();

        // weekly OR final
        $table->enum('type', ['weekly', 'final']);

        // for weekly reports
        $table->unsignedTinyInteger('week_number')->nullable();

        $table->string('title')->nullable();
        $table->longText('content')->nullable();

        // file upload (pdf/docx)
        $table->string('file_path')->nullable();

        // approval
        $table->boolean('is_submitted')->default(false);
        $table->boolean('is_approved')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
