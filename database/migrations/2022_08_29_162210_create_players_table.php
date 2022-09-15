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
            $table->string('status');
            $table->string('status_comment')->nullable();
            $table->timestamp('status_at')->nullable();
            $table->integer('chance_of_playing')->nullable();
            $table->date('returned_at')->nullable();
            $table->integer('fpl_id')->unsigned()->unique();
            $table->integer('fot_mob_id')->unsigned()->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
