<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manager_pick', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained();
            $table->foreignId('player_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();

            $table->boolean('is_captain')->default(false);
            $table->boolean('is_vice_captain')->default(false);
            $table->tinyInteger('multiplier');
            $table->tinyInteger('position');

            $table->integer('points')->nullable();
            $table->integer('clean_points')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager_pick');
    }
};
