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
       Schema::create('budgets', function (Blueprint $table) {
    $table->id();

    $table->foreignId('lecturer_id')
          ->constrained('lecturers')
          ->cascadeOnDelete();

    $table->string('town');                 // Thika, Nairobi, Embu, etc
    $table->unsignedInteger('students_count');

    $table->enum('trip_type', ['day', 'night']);
    $table->unsignedInteger('days');        // 1 day, 2 nights, etc

    $table->decimal('transport_amount', 10, 2)->default(0);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
