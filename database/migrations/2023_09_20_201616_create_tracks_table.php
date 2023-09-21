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
        Schema::create('tracks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->uuid('album_id')->nullable();
            $table->integer('popularity')->nullable();
            $table->integer('track_number')->nullable();
            $table->string('uri')->nullable();
            $table->foreign('album_id')->references('id')->on('albums');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
        });

        Schema::dropIfExists('tracks');
    }
};
