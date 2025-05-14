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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('resume')->nullable();
            
            // Rename address column to location if it exists
            if (Schema::hasColumn('candidate_profiles', 'address')) {
                $table->renameColumn('address', 'location');
            } else {
                $table->string('location')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn(['website', 'linkedin', 'resume']);
            
            // Reverse the rename
            if (Schema::hasColumn('candidate_profiles', 'location')) {
                $table->renameColumn('location', 'address');
            }
        });
    }
};
