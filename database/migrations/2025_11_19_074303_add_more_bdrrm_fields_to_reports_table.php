<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('reports', function (Blueprint $table) {
        $table->string('clearing_teams')->nullable();
        $table->string('power_utility_agency')->nullable();
        $table->string('structural_assessment_teams')->nullable();
    });
}

public function down()
{
    Schema::table('reports', function (Blueprint $table) {
        $table->dropColumn([
            'clearing_teams',
            'power_utility_agency',
            'structural_assessment_teams',
        ]);
    });
}

};
