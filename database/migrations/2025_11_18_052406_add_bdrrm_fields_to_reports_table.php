<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // For each group we check first whether the column exists to avoid duplicate column errors.
        if (! Schema::hasColumn('reports', 'overseer')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('overseer')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'medical_response')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('medical_response')->nullable();
                $table->integer('ambulance_units')->nullable();
                $table->string('designated_hospitals')->nullable();
                $table->string('hospital_address')->nullable();
            });
        }

        // Evacuation: skip if evacuation_site (or the group) already exists
        if (! Schema::hasColumn('reports', 'evacuation_transport')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('evacuation_address')->nullable(); // if already exists, Schema::hasColumn prevented reach here
                $table->string('evacuation_transport')->nullable();
                $table->integer('evacuation_transport_unit')->nullable();
                $table->string('relief_goods_provider')->nullable();
            });
        } else {
            // If evacuation_transport exists but evacuation_site may not, check individually:
            if (! Schema::hasColumn('reports', 'relief_goods_provider')) {
                Schema::table('reports', function (Blueprint $table) {
                    $table->string('relief_goods_provider')->nullable();
                });
            }
        }

        if (! Schema::hasColumn('reports', 'pnp_station')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('pnp_station')->nullable();
                $table->integer('pnp_patrol_unit')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'fire_department')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('fire_department')->nullable();
                $table->string('fire_team')->nullable();
                $table->integer('fire_truck_units')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'water_rescue_response_unit')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('water_rescue_response_unit')->nullable();
                $table->integer('rubber_boat_units')->nullable();
                $table->integer('lifeguard_rescue_personnel')->nullable();
                $table->string('search_rescue_team')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'safety_and_security')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('safety_and_security')->nullable();
                $table->string('relief_welfare')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'road_clearance_team')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('road_clearance_team')->nullable();
                $table->string('traffic_diversion_sites')->nullable();
                $table->string('first_aid_station')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'responding_team_complaints')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('responding_team_complaints')->nullable();
                $table->string('complaints_actions')->nullable();
                $table->string('responding_team_suggestion')->nullable();
            });
        }

        if (! Schema::hasColumn('reports', 'inspection_date')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->date('inspection_date')->nullable();
                $table->string('recommended_action')->nullable();
            });
        }
    }

    public function down()
    {
        // In down(), only drop columns that exist (safe for sqlite)
        $cols = [
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
        ];

        foreach ($cols as $col) {
            if (Schema::hasColumn('reports', $col)) {
                Schema::table('reports', function (Blueprint $table) use ($col) {
                    $table->dropColumn($col);
                });
            }
        }
    }
};

