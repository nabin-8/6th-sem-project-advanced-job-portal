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
        'title',
        'description',
        'requirements',
        'location',
        'salary',
        'status',
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
}