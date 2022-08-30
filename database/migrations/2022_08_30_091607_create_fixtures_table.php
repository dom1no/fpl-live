<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gameweek_id')->constrained();
            $table->dateTime('kickoff_time');
            $table->boolean('is_started')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_finished_provisional')->default(false);
            $table->integer('minutes')->unsigned()->default(0);
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->integer('home_team_score')->unsigned()->nullable();
            $table->integer('away_team_score')->unsigned()->nullable();
            $table->integer('fpl_id')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
};
