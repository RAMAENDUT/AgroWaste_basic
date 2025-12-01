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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_module_id');
            $table->unsignedBigInteger('exercise_id');
            $table->tinyInteger('score')->default(0); // 0-100
            $table->boolean('passed')->default(false);
            $table->integer('correct_answers')->default(0);
            $table->integer('total_questions')->default(0);
            $table->text('answers')->nullable(); // JSON answers
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('no action');
            $table->foreign('course_module_id')->references('id')->on('course_modules')->onDelete('no action');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
