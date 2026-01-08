<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $primaryKey = 'response_id';

    protected $fillable = [
        'report_id',
        'reference_ID',
        'response_datetime',
        'dispatch_unit',
        'contact_person',
        'contact_number',
        'overseer',
        'medical_response',
        'ambulance_units',
        'designated_hospitals',
        'hospital_address',
        'hospital_latitude',
        'hospital_longitude',
        'evacuation_address',
        'evacuation_latitude',
        'evacuation_longitude',
        'evacuation_transport',
        'evacuation_transport_unit',
        'relief_goods_provider',
        'pnp_station',
        'pnp_patrol_unit',
        'pnp_team_unit',
        'fire_department',
        'fire_team',
        'fire_truck_units',
        'water_rescue_response_unit',
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
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
    public function feedback()
{
    return $this->hasOne(Feedback::class, 'response_id', 'response_id');
}

}
