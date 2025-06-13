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
        Schema::create('salary_payouts', function (Blueprint $table) {
            $table->id();
            $table->morphs('payee');
            $table->integer('amount');
            $table->date('salary_month');
            $table->date('paid_on');
            $table->timestamps();
            $table->unique(['payee_type', 'payee_id', 'salary_month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_payouts');
    }
};
