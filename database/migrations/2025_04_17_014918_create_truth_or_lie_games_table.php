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
        Schema::create('truth_or_lie_games', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->string('image')->nullable();
            $table->json('game_data'); // Тут зберігається JSON-файл з твердженнями
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['game_id']); // Drop the foreign key for likes
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['game_id']); // Drop the foreign key for comments
        });

        schema::dropIfExists('truth_or_lie_games');
    }
};
