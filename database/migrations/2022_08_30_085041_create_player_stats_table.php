<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();

            $table->integer('minutes')->unsigned()->default(0);
            $table->integer('goals_scored')->unsigned()->default(0);
            $table->integer('assists')->unsigned()->default(0);
            $table->integer('goals_conceded')->unsigned()->default(0);
            $table->integer('own_goals')->unsigned()->default(0);
            $table->integer('penalties_saved')->unsigned()->default(0);
            $table->integer('penalties_missed')->unsigned()->default(0);
            $table->integer('yellow_cards')->unsigned()->default(0);
            $table->integer('red_cards')->unsigned()->default(0);
            $table->integer('saves')->unsigned()->default(0);
            $table->integer('bonus')->unsigned()->default(0);
            $table->integer('bps')->default(0);
            $table->float('influence')->default(0);
            $table->float('creativity')->default(0);
            $table->float('threat')->default(0);
            $table->float('ict_index')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};
