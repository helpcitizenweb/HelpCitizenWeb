<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Primary key (custom, like Response)
     */
    protected $primaryKey = 'feedback_id';
    protected $table = 'feedbacks';

    public $incrementing = true;

    protected $keyType = 'int';
    protected $casts = [
    'admin_responded_at' => 'datetime',
    'feedback_date'      => 'date',
    'feedback_time'      => 'datetime',
];


    /**
     * Mass assignable fields
     */
    protected $fillable = [
        // Relationships
        'report_id',
        'response_id',
        'user_id',

        // Ratings
        'rating',
        'response_speed_rating',
        'resolution_rating',

        // Feedback content
        'feedback',

        // Media
        'photo',
        'video',

        // Admin side
        'admin_response',
        'admin_id',
        'admin_responded_at',

        // Moderation
        'is_anonymous',
        'is_reviewed',

        // Time tracking
        'feedback_date',
        'feedback_time',
    ];

    /**
     * =====================
     * Relationships
     * =====================
     */

    /**
     * Feedback belongs to a Report
     * One-to-one (Report hasOne Feedback)
     */
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    /**
     * Feedback belongs to a Response
     * Note: Response uses response_id as PK
     */
    public function response()
    {
        return $this->belongsTo(Response::class, 'response_id', 'response_id');
    }

    /**
     * Resident / user who submitted the feedback
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Admin who responded to the feedback
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
