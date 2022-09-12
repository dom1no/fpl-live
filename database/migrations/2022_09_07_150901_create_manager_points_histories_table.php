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

            $table->integer('points')->default(0);
            $table->integer('transfers_cost')->default(0);
            $table->integer('total_points')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manager_points_histories');
    }
};
