<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_module_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->string('status')->default('not_started');
            $table->unsignedTinyInteger('progress_percent')->default(0);
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id','module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_module_progress');
    }
};
