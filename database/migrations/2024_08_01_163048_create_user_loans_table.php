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
        Schema::create('user_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_image')->nullable();
            $table->string('value');
            $table->date('loan_maturity');
            $table->string('loan_description');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('loan_modality_id')->constrained('loan_modalities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_loans');
    }
};
