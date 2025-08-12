<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scheduled_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->string('channel_name', 191)->nullable()->index();
            $table->timestamp('scheduled_at');
            $table->unsignedSmallInteger('duration_minutes')->default(30);
            $table->enum('status', ['scheduled', 'cancelled', 'started', 'completed'])->default('scheduled');
            $table->foreignId('call_id')->nullable()->constrained('calls')->nullOnDelete();
            $table->timestamps();
            $table->index(['created_by', 'scheduled_at']);
            $table->index(['section_id', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_calls');
    }
};