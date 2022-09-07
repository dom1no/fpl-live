<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixture_team', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fixture_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->unique(['fixture_id', 'team_id']);

            $table->boolean('is_home')->default(false);
            $table->unique(['fixture_id', 'team_id', 'is_home']);

            $table->integer('score')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixture_team');
    }
};
