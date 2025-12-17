<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            
            
            $table->foreignId('attachment_student_id')
                                    ->onDelete('cascade')          
                  ->after('id');                 
        });
    }

    
    public function down(): void
    {
        Schema::table('attachment_assessments', function (Blueprint $table) {
            
            $table->dropConstrainedForeignId('attachment_student_id'); 
            
            
        });
    }
};