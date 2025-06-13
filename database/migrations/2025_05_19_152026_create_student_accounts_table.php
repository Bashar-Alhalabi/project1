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
        Schema::create('student_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->integer('debit')->nullable();
            $table->integer('credit')->nullable();
            $table->string('description');
            $table->foreignId('fee_invoice_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('student_discount_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('student_receipt_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('processing_fee_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('payment_to_student_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_accounts');
    }
};
