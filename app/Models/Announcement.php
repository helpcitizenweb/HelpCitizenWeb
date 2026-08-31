<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'content',

    'image',

    'disaster_type',
    'alert_level',
    'affected_area',

    'instructions',

    'evacuation_center',

    'medical_facility_name',
    'medical_facility_contact',

    'security_coordination_note',

    'start_datetime',
    'end_datetime',

    'status',
    'is_urgent',

    'issued_by',
    'reference_source',
];

}

