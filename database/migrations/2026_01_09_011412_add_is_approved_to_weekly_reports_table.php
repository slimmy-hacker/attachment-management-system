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
    Schema::table('weekly_reports', function (Blueprint $table) {
        $table->boolean('is_approved')->default(false)->after('lecturer_comment');
    });
}

public function down()
{
    Schema::table('weekly_reports', function (Blueprint $table) {
        $table->dropColumn('is_approved');
    });
}

};
