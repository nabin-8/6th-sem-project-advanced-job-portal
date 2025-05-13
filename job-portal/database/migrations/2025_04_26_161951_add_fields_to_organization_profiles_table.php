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
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->integer('founded_year')->nullable();
            $table->string('email')->nullable();
            // $table->string('location')->nullable();
            $table->text('mission')->nullable();
            $table->text('benefits')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('company_brochure')->nullable();
            $table->boolean('is_complete')->default(false);
            
            // Rename logo_path to logo for consistency
            $table->renameColumn('logo_path', 'logo');
            
            // Rename address to location if not already done
            if (Schema::hasColumn('organization_profiles', 'address')) {
                $table->renameColumn('address', 'location');
            }
            
            // Rename company_name to name for consistency
            $table->renameColumn('company_name', 'name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'founded_year',
                'email',
                'mission',
                'benefits',
                'linkedin',
                'twitter',
                'banner_image',
                'company_brochure',
                'is_complete'
            ]);
            
            // Reverse renaming
            $table->renameColumn('logo', 'logo_path');
            $table->renameColumn('name', 'company_name');
            
            // Only do this if we renamed it in the up method
            if (!Schema::hasColumn('organization_profiles', 'address')) {
                $table->renameColumn('location', 'address');
            }
        });
    }
};
