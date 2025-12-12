<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {

            // Primary key
            $table->id('response_id');

            // Link to reports
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')
                  ->references('id')
                  ->on('reports')
                  ->onDelete('cascade');

            // Unique reference ID for tracking
            $table->string('reference_ID')->unique();

            // Response date & time
            $table->dateTime('response_datetime')->nullable();

            // General fields
            $table->string('dispatch_unit')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('overseer')->nullable();

            // Medical / hospitals
            $table->text('medical_response')->nullable();
            $table->string('ambulance_units')->nullable();
            $table->string('designated_hospitals')->nullable();
            $table->string('hospital_address')->nullable();
            $table->decimal('hospital_latitude', 10, 7)->nullable();
            $table->decimal('hospital_longitude', 10, 7)->nullable();

            // Evacuation site
            $table->string('evacuation_address')->nullable();
            $table->decimal('evacuation_latitude', 10, 7)->nullable();
            $table->decimal('evacuation_longitude', 10, 7)->nullable();
            $table->string('evacuation_transport')->nullable();
            $table->string('evacuation_transport_unit')->nullable();
            $table->string('relief_goods_provider')->nullable();

            // PNP
            $table->string('pnp_station')->nullable();
            $table->string('pnp_patrol_unit')->nullable();
            $table->string('pnp_team_unit')->nullable();

            // Fire
            $table->string('fire_department')->nullable();
            $table->string('fire_team')->nullable();
            $table->string('fire_truck_units')->nullable();

            // Water rescue
            $table->string('water_rescue_response_unit')->nullable();
            $table->string('lifeguard_rescue_personnel')->nullable();
            $table->string('search_rescue_team')->nullable();

            // Welfare & security
            $table->string('safety_and_security')->nullable();
            $table->string('relief_welfare')->nullable();

            // Traffic
            $table->string('road_clearance_team')->nullable();
            $table->string('traffic_diversion_sites')->nullable();

            // First Aid
            $table->string('first_aid_station')->nullable();

            // Complaints category
            $table->string('responding_team_complaints')->nullable();
            $table->text('complaints_actions')->nullable();
            $table->string('responding_team_suggestion')->nullable();

            // Services (technical)
            $table->date('inspection_date')->nullable();
            $table->text('recommended_action')->nullable();

            // Earthquake / clearing
            $table->string('clearing_teams')->nullable();
            $table->string('power_utility_agency')->nullable();
            $table->string('structural_assessment_teams')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
