<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('player_stats', function (Blueprint $table) {
            $table->double('xg')->nullable();
            $table->double('xa')->nullable();
            $table->double('fot_mob_rating')->nullable();
            $table->boolean('is_main')->default(false);
            $table->boolean('is_bench')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('player_stats', function (Blueprint $table) {
            $table->dropColumn('xg');
            $table->dropColumn('xa');
            $table->dropColumn('fot_mob_rating');
        });
    }
};
