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
        Schema::create('feedbacks', function (Blueprint $table) {
    $table->bigIncrements('feedback_id');

    // Relationships
    $table->unsignedBigInteger('report_id')->unique();
    $table->unsignedBigInteger('response_id')->nullable(); // ✅ FIX
    $table->unsignedBigInteger('user_id');

    // Ratings
    $table->tinyInteger('rating');
    $table->tinyInteger('response_speed_rating')->nullable();
    $table->tinyInteger('resolution_rating')->nullable();

    // Feedback content
    $table->text('feedback');

    // Media
    $table->string('photo')->nullable();
    $table->string('video')->nullable();

    // Admin response
    $table->text('admin_response')->nullable();
    $table->unsignedBigInteger('admin_id')->nullable();
    $table->timestamp('admin_responded_at')->nullable();

    // Moderation
    $table->boolean('is_anonymous')->default(false);
    $table->boolean('is_reviewed')->default(false);

    // Time tracking
    $table->date('feedback_date');
    $table->time('feedback_time');

    $table->timestamps();

    // Foreign keys
    $table->foreign('report_id')
          ->references('id')->on('reports')
          ->cascadeOnDelete();

    $table->foreign('response_id')
          ->references('response_id')->on('responses')
          ->cascadeOnDelete();

    $table->foreign('user_id')
          ->references('id')->on('users')
          ->cascadeOnDelete();

    $table->foreign('admin_id')
          ->references('id')->on('users')
          ->nullOnDelete();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
