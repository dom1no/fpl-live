<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gameweeks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('deadline_at');
            $table->boolean('is_finished');
            $table->boolean('is_previous');
            $table->boolean('is_current');
            $table->boolean('is_next');
            $table->integer('fpl_id')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gameweeks');
    }
};
