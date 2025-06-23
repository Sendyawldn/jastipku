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
        Schema::table('orders', function (Blueprint $table) {
            // Rating system
            $table->tinyInteger('customer_rating')->nullable()->after('completed_at');
            $table->text('customer_review')->nullable()->after('customer_rating');

            // Cancel reason
            $table->string('cancel_reason')->nullable()->after('customer_review');
            $table->timestamp('cancelled_at')->nullable()->after('cancel_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_rating',
                'customer_review',
                'cancel_reason',
                'cancelled_at'
            ]);
        });
    }
};
