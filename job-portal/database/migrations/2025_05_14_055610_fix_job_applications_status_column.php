<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite we need to recreate the table to change the enum 
        // First create a temporary table with the correct structure
        Schema::create('job_applications_new', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');
            $table->integer('candidate_id');
            $table->text('cover_letter')->nullable();
            // New status column with the correct allowed values
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('last_contact')->nullable();
            $table->timestamps();
        });

        // Copy data from old table to new table
        DB::statement('INSERT INTO job_applications_new 
                      SELECT id, job_id, candidate_id, cover_letter, status, admin_notes, 
                      last_contact, created_at, updated_at 
                      FROM job_applications');

        // Drop the old table
        Schema::dropIfExists('job_applications');

        // Rename the new table to the original name
        Schema::rename('job_applications_new', 'job_applications');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // Convert back to enum if needed, but this is not directly possible with SQLite
            // We'd need to do the same table recreation process in reverse
        });
    }
};
