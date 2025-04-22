<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск міграції.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->ulid();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade'); // Зв'язок з користувачем, який створив гру
            $table->string('status')->default('active'); // Статус гри (наприклад, active, finished)
            $table->timestamp('started_at')->nullable(); // Час початку гри
            $table->timestamp('ended_at')->nullable(); // Час завершення гри
            $table->timestamps();
        });
    }

    /**
     * Відкотити міграцію.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_sessions');
    }
};
