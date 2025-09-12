<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'type')) {
                $table->string('type')->nullable()->after('description');
            }
            if (!Schema::hasColumn('reports', 'subtype')) {
                $table->string('subtype')->nullable()->after('type');
            }
            if (!Schema::hasColumn('reports', 'location')) {
                $table->string('location')->nullable()->after('subtype');
            }
            if (!Schema::hasColumn('reports', 'urgency')) {
                $table->string('urgency')->nullable()->after('location');
            }
            if (!Schema::hasColumn('reports', 'status')) {
                $table->string('status')->default('Pending')->after('urgency');
            }
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            if (Schema::hasColumn('reports', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('reports', 'subtype')) {
                $table->dropColumn('subtype');
            }
            if (Schema::hasColumn('reports', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('reports', 'urgency')) {
                $table->dropColumn('urgency');
            }
            if (Schema::hasColumn('reports', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
