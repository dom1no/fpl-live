<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
            $table->string('position', 3);
            $table->float('price')->index();
            $table->foreignId('team_id')->constrained();
            $table->integer('fpl_id')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
};
