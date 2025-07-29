<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies';
    protected $casts = [
        'requirements' => 'array',
        'application_deadline' => 'datetime',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'category_id',
        'title',
        'description',
        'requirements',
        'location',
        'employment_type',
        'salary_min',
        'salary_max',
        'application_deadline',
        'is_featured',
        'status',
        'slug',
    ];

    /**
     * Get the organization that owns the job.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(OrganizationProfile::class, 'organization_id');
    }

    /**
     * Get the applications for the job.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope a query to only include open jobs.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
    
    /**
     * Get the category that the job belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }
    
    /**
     * Get the requirements attribute, handling both array and string formats.
     */
    public function getRequirementsAttribute($value)
    {
        // If value is null or empty, return empty array
        if (empty($value)) {
            return [];
        }
        
        // If it's already an array (from cast), return it
        if (is_array($value)) {
            return $value;
        }
        
        // If it's a string, try to decode as JSON
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
            
            // If not valid JSON, split by newlines or commas and clean up
            $requirements = preg_split('/[\r\n,]+/', $value);
            $requirements = array_filter(array_map('trim', $requirements));
            return array_values($requirements); // Re-index array
        }
        
        // Fallback: return as single-item array
        return [$value];
    }
}