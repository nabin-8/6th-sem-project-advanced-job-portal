<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'website',
        'industry',
        'company_size',
        'logo',
        'phone',
        'location',
        'founded_year',
        'email',
        'mission',
        'benefits',
        'linkedin',
        'twitter',
        'banner_image',
        'company_brochure',
        'is_complete',
    ];

    /**
     * Get the user that owns the organization profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the jobs posted by the organization.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'organization_id');
    }
    
    /**
     * Get the required fields for profile completion.
     * 
     * @return array
     */
    public static function getRequiredFields(): array
    {
        return [
            'name',
            'industry',
            'description',
            'location',
            'website',
            'logo'
        ];
    }
}
