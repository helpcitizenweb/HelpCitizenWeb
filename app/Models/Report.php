<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'name',
    'email',
    'phone',
    'title',
    'description',
    'image',
    'video',
    'type',
    'subtype',
    'location',
    'urgency',
    'anonymous',
    'status',

    // Existing resolution fields
    'evacuation_site',    // already in DB before
    'dispatch_unit',
    'contact_person',
    'contact_number',

    // Demographics
    'casualties',
    'gender',

    // NEW BDRRM FIELDS
    'overseer',
    'medical_response',
    'ambulance_units',
    'designated_hospitals',
    'hospital_address',

    'evacuation_address',
    'evacuation_transport',
    'evacuation_transport_unit',
    'relief_goods_provider',

    'pnp_station',
    'pnp_patrol_unit',

    'fire_department',
    'fire_team',
    'fire_truck_units',

    'water_rescue_response_unit',
    'rubber_boat_units',
    'lifeguard_rescue_personnel',
    'search_rescue_team',

    'safety_and_security',
    'relief_welfare',

    'road_clearance_team',
    'traffic_diversion_sites',
    'first_aid_station',

    'responding_team_complaints',
    'complaints_actions',

    'responding_team_suggestion',

    'inspection_date',
    'recommended_action',
    'clearing_teams',
    'power_utility_agency',
    'structural_assessment_teams',
    'pnp_team_unit',



];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function response()
{
    return $this->hasOne(Response::class, 'report_id');
}
public function feedback()
{
    return $this->hasOne(Feedback::class);
}

}
