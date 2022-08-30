<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();

            $table->string('action');
            $table->integer('value');
            $table->integer('points');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_points');
    }
};
