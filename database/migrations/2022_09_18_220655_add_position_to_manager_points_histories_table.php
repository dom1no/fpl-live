<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manager_points_histories', function (Blueprint $table) {
            $table->integer('position')->unsigned()->default(0);
            $table->integer('total_position')->unsigned()->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('manager_points_histories', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('total_position');
        });
    }
};
