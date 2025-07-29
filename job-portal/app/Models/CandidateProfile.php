<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'resume_path',
        'resume',  // Add this for the new field name
        'skills',
        'education',
        'experience',
        'phone',
        'address', // This is the actual column name in the database
        'website',
        'linkedin',
        'is_complete',
    ];

    /**
     * Get the user that owns the candidate profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job applications for the candidate.
     */
    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'candidate_id');
    }
    
    /**
     * Get the required fields for profile completion.
     * 
     * @return array
     */
    public static function getRequiredFields(): array
    {
        return [
            'headline',
            'bio',
            'location', // Using 'location' instead of 'address' for consistency with UI
            'phone',
            'skills',
            'resume' // Using the new field name
        ];
    }
}
