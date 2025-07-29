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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string('employment_type')->nullable()->after('location');
            $table->decimal('salary_min', 10, 2)->nullable()->after('salary');
            $table->decimal('salary_max', 10, 2)->nullable()->after('salary_min');
            $table->dateTime('application_deadline')->nullable()->after('salary_max');
            $table->boolean('is_featured')->default(false)->after('application_deadline');
            
            // Drop the old salary column if it exists (we're replacing it with min/max)
            if (Schema::hasColumn('vacancies', 'salary')) {
                $table->dropColumn('salary');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            // Add back the single salary column
            $table->decimal('salary', 10, 2)->nullable()->after('location');
            
            // Remove the new columns
            $table->dropColumn([
                'employment_type',
                'salary_min',
                'salary_max',
                'application_deadline',
                'is_featured'
            ]);
        });
    }
};
