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
        // Since SQLite doesn't support altering enum columns or check constraints easily
        // We'll handle validation in the model and controller instead
        // No database changes needed
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
