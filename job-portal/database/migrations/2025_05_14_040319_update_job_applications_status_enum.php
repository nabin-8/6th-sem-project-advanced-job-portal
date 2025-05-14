<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need a different approach
        // We'll handle validation in the model and controller instead
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No change needed since we didn't modify the database
    }
};
