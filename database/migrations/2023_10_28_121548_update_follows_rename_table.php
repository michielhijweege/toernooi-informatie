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
        Schema::table('follows', function (Blueprint $table) {
            // Add a new column with the desired name
            $table->integer('user_id')->after('player_id');
        });

        // Copy data from the old column to the new one
        \DB::statement('UPDATE follows SET user_id = player_id');

        Schema::table('follows', function (Blueprint $table) {
            // Drop the old column
            $table->dropColumn('player_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
