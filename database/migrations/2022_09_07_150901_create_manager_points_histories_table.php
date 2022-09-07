<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('manager_points_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manager_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();
            $table->unique(['manager_id', 'gameweek_id']);

            $table->integer('gameweek_points');
            $table->integer('total_points');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manager_points_histories');
    }
};
