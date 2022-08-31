<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gameweek_id')->constrained();
            $table->dateTime('kickoff_time');
            $table->boolean('is_started')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_finished_provisional')->default(false);
            $table->integer('minutes')->unsigned()->default(0);
            $table->integer('fpl_id')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
