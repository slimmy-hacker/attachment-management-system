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
   Schema::create('logbooks', function (Blueprint $table) {


       $table->id();
       $table->integer('attachment_student_id');
      $table->integer('logbook_week_id');
       $table->integer('week_id');
       $table->date('start_date');
       $table->date('end_date');
       $table->string('task_title');
       $table->string('tasks');
       $table->string('skills_learned');
       $table->string('challenges')->nullable();
       $table->timestamps();
       $table->softDeletes();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
