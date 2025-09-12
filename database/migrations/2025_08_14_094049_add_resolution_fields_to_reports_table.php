<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new Class extends Migration {
    
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('evacuation_site')->nullable();
            $table->string('dispatch_unit')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number', 20)->nullable();
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['evacuation_site', 'dispatch_unit', 'contact_person', 'contact_number']);
        });
    }
};