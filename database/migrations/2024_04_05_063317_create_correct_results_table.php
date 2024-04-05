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
            $table->string('letters_mapping');
            $table->string('first_input');
            $table->string('second_input');
            $table->string('third_input');
            $table->unsignedInteger('sum_input');
            $table->unsignedInteger('query_first_input');
            $table->unsignedInteger('query_second_input');
            $table->unsignedInteger('query_third_input');
            $table->unsignedInteger('query_sum');
            $table->unsignedInteger('attempts');
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
