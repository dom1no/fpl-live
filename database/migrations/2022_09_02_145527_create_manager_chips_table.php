<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('manager_chips', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manager_id')->constrained();
            $table->foreignId('gameweek_id')->constrained();
            $table->string('type');
            $table->unique(['manager_id', 'gameweek_id', 'type']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manager_chips');
    }
};
