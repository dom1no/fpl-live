<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('command_name');
            $table->integer('total_points')->index();
            $table->integer('fpl_id')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('managers');
    }
};
