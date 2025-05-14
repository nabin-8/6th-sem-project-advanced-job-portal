<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'candidate_id',
        'cover_letter',
        'status',
        'admin_notes',
        'last_contact',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_contact' => 'datetime',
    ];
    
    /**
     * Valid values for the status attribute
     * 
     * @var array
     */
    public static $validStatuses = [
        'pending', 'reviewing', 'interview', 'offered', 'rejected', 'withdrawn'
    ];
    
    /**
     * Set the status attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::$validStatuses)) {
            throw new \InvalidArgumentException('Invalid status value: ' . $value);
        }
        
        $this->attributes['status'] = $value;
    }

    /**
     * Get the job that owns the application.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the candidate that owns the application.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class, 'candidate_id');
    }

}