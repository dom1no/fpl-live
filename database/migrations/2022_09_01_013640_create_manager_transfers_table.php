<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('manager_transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manager_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();

            $table->foreignId('player_out_id')->constrained('players');
            $table->float('player_out_cost')->unsigned();
            $table->foreignId('player_in_id')->constrained('players');
            $table->float('player_in_cost')->unsigned();
            $table->boolean('is_free');
            $table->dateTime('happened_at');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manager_transfers');
    }
};
