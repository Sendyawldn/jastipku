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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Customer info
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('traveler_id')->nullable()->constrained('users')->onDelete('set null');

            // Order details
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('kategori');
            $table->decimal('budget', 12, 2);
            $table->string('destination'); // Kota tujuan
            $table->date('deadline');

            // Order status
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'cancelled'])->default('pending');

            // Additional info
            $table->text('catatan_khusus')->nullable();
            $table->string('link_produk')->nullable();
            $table->json('foto_produk')->nullable(); // Untuk menyimpan multiple foto

            // Payment info
            $table->decimal('ongkos_jasa', 10, 2)->nullable();
            $table->decimal('total_belanja', 12, 2)->nullable();
            $table->decimal('total_pembayaran', 12, 2)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');

            // Delivery info
            $table->string('alamat_pengiriman')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('metode_pengiriman')->nullable();
            $table->string('resi_pengiriman')->nullable();

            // Timestamps
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['customer_id', 'status']);
            $table->index(['traveler_id', 'status']);
            $table->index(['destination']);
            $table->index(['kategori']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
