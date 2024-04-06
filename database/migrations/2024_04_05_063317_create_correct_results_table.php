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
        Schema::create('correct_results', function (Blueprint $table) {
            $table->id();
            $table->string('letters');
            $table->unsignedInteger('sum_letters');
            $table->unsignedInteger('result');
            $table->unsignedInteger('found_at_round');
            $table->unsignedInteger('max_round');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correct_results');
    }
};
