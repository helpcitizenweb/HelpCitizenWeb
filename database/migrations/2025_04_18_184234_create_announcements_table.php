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
        // Check if the table already exists
        if (!Schema::hasTable('announcements')) {
            Schema::create('announcements', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content');
                $table->timestamps();
            });
        } else {
            // If the table exists but missing columns, add them
            Schema::table('announcements', function (Blueprint $table) {
                if (!Schema::hasColumn('announcements', 'title')) {
                    $table->string('title');
                }
                if (!Schema::hasColumn('announcements', 'content')) {
                    $table->text('content');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
