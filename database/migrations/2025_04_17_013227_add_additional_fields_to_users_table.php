<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use k1fl1k\truefalsegame\Enum\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop and recreate the ID with ULID
            $table->dropColumn('id');
            $table->ulid('id')->primary(); // Add ULID as new ID

            // Rename and modify username
            $table->renameColumn('name', 'username');
            $table->string('username')->unique()->change();

            $table->enum('role', array_column(Role::cases(), 'value'))->default(Role::USER->value);  // Default role
            $table->string('avatar', 2048)->nullable();
            $table->text('description', 2048)->nullable();
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
            $table->foreignUlid('user_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop columns and revert to previous state
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->id();

            $table->dropColumn('role');
            $table->dropColumn('avatar');
            $table->dropColumn('description');
        });

        // Drop the ENUM types


        // Modify the sessions table
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
            $table->foreignId('user_id')->nullable()->index();
        });
    }
};
