<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
            $table->string('position', 3);
            $table->float('price');
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->integer('fpl_id')->unsigned()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
