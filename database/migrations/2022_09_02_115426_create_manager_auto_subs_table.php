<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('manager_auto_subs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manager_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();

            $table->foreignId('player_out_id')->constrained('players');
            $table->foreignId('player_in_id')->constrained('players');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manager_auto_subs');
    }
};
