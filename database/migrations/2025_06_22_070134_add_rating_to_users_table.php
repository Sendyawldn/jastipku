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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->nullable()->after('email_verified_at');
            $table->integer('total_reviews')->default(0)->after('rating');
            $table->integer('completed_orders_count')->default(0)->after('total_reviews');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rating', 'total_reviews', 'completed_orders_count']);
        });
    }
};
