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
        Schema::create('traveler_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique()->nullable();
            $table->string('id_card_path')->nullable();
            $table->string('travel_schedule')->nullable();
            $table->text('travel_purpose')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->text('bio')->nullable();
            $table->json('travel_destinations')->nullable();
            $table->json('specialties')->nullable();
            $table->boolean('available_for_orders')->default(true);
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveler_profiles');
    }
};