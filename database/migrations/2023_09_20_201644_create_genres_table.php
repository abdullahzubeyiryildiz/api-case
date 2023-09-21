<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('track_id');
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropForeign(['track_id']);
        });

        Schema::dropIfExists('genres');
    }
};
