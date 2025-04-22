<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->ulid();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade'); // Зв'язок з користувачем
            $table->text('description'); // Опис активності
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
        Schema::dropIfExists('activity_logs');
    }
};
