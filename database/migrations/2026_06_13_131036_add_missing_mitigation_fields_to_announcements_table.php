<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('announcements', function (Blueprint $table) {

        $table->string('image')->nullable();

        $table->string('disaster_type')->nullable();
        $table->string('alert_level')->nullable();
        $table->string('affected_area')->nullable();

        $table->text('instructions')->nullable();

        $table->string('evacuation_center')->nullable();

        $table->string('medical_facility_name')->nullable();
        $table->string('medical_facility_contact')->nullable();

        $table->text('security_coordination_note')->nullable();

        $table->dateTime('start_datetime')->nullable();
        $table->dateTime('end_datetime')->nullable();

        $table->string('status')->nullable();

        $table->boolean('is_urgent')->default(false);

        $table->string('issued_by')->nullable();

        $table->string('reference_source')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('announcements', function (Blueprint $table) {

        $table->dropColumn([
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
        ]);

    });
}
};
