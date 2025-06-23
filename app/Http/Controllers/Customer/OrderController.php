<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    private function calculateOngkosJasaOtomatis($budget, $destination)
    {
        $basePercentage = 0.15; // 15% dari budget
        $shippingMultiplier = 1.0;

        // Logika multiplier berdasarkan pulau/destinasi
        $pulauMultipliers = [
            'jakarta' => 1.0, 'bandung' => 1.0, 'surabaya' => 1.0, 'yogyakarta' => 1.0, 'semarang' => 1.0, 'malang' => 1.0, 'solo' => 1.0, 'bogor' => 1.0, 'depok' => 1.0, 'tangerang' => 1.0, 'bekasi' => 1.0, // Jawa
            'medan' => 1.2, 'palembang' => 1.2, 'pekanbaru' => 1.2, 'padang' => 1.2, 'bandar_lampung' => 1.2, 'batam' => 1.2, // Sumatera
            'banjarmasin' => 1.3, 'balikpapan' => 1.3, 'samarinda' => 1.3, 'pontianak' => 1.3, // Kalimantan
            'makassar' => 1.3, 'manado' => 1.3, 'palu' => 1.3, 'kendari' => 1.3, // Sulawesi
            'denpasar' => 1.4, 'mataram' => 1.4, 'kupang' => 1.4, 'labuan_bajo' => 1.4, // Bali & Nusa Tenggara
            'jayapura' => 1.6, 'ambon' => 1.6, 'sorong' => 1.6, 'merauke' => 1.6, // Papua & Maluku
        ];

        // Normalisasi nama destinasi (misal: "bandar_lampung" ke "bandar lampung" jika diperlukan, tapi sebaiknya gunakan nilai konsisten)
        // Pastikan nilai $destination sesuai dengan keys di $pulauMultipliers
        $destinationKey = Str::slug($destination, '_'); // Mengubah "Bandar Lampung" menjadi "bandar_lampung"

        if (isset($pulauMultipliers[$destinationKey])) {
            $shippingMultiplier = $pulauMultipliers[$destinationKey];
        }

        return $budget * $basePercentage * $shippingMultiplier;
    }


    public function index()
    {
        $orders = Auth::user()->ordersAsCustomer()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->get();

        return view('customer.pesanan_saya', compact('orders'));
    }

    public function create()
    {
        return view('customer.create_order');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'budget' => 'required|numeric|min:50000',
            'destination' => 'required|string',
            'deadline' => 'required|date|after:+2 days',
            'catatan_khusus' => 'nullable|string',
            'foto_produk.*' => 'nullable|image|max:2048',
            'alamat_pengiriman' => 'required|string',
            'no_telepon' => 'required|string',
            'metode_pembayaran' => 'required|string|in:bank_transfer,ewallet,virtual_account,qris,cash_on_delivery',
        ]);

        // Hitung ongkos jasa otomatis
        $ongkosJasaOtomatis = $this->calculateOngkosJasaOtomatis($validated['budget'], $validated['destination']);

        // Handle multiple file uploads
        $fotoProduk = [];
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $fotoProduk[] = $file->store('order-images', 'public');
            }
        }

        Order::create([
            'customer_id' => Auth::id(),
            'nama_barang' => $validated['nama_barang'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'budget' => $validated['budget'],
            'destination' => $validated['destination'],
            'deadline' => $validated['deadline'],
            'catatan_khusus' => $validated['catatan_khusus'],
            'foto_produk' => $fotoProduk,
            'alamat_pengiriman' => $validated['alamat_pengiriman'],
            'no_telepon' => $validated['no_telepon'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'ongkos_jasa_otomatis' => $ongkosJasaOtomatis, // Simpan ongkos jasa otomatis
            'status' => 'pending',
        ]);

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Order $order)
    {
        // Authorization
        if (auth()->id() !== $order->customer_id) {
            abort(403, 'Akses ditolak');
        }

        return view('customer.order_detail', compact('order'));
    }

    public function destroy(Order $order)
    {
        // Authorization
        if (auth()->id() !== $order->customer_id) {
            abort(403, 'Akses ditolak');
        }

        // Business logic: only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function edit(Order $order)
    {
        // Hanya bisa edit jika status pending dan milik user yang login
        if ($order->status !== 'pending' || $order->customer_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.edit_order', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Authorization
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        // Business logic: only pending orders can be edited
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat diedit karena sudah diproses.');
        }

        // Validation
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'budget' => 'required|numeric|min:50000',
            'destination' => 'required|string',
            'deadline' => 'required|date|after:+2 days',
            'catatan_khusus' => 'nullable|string',
            'alamat_pengiriman' => 'required|string',
            'no_telepon' => 'required|string',
        ]);

        // Hitung ulang ongkos jasa otomatis jika budget atau destination berubah
        $ongkosJasaOtomatis = $this->calculateOngkosJasaOtomatis($validated['budget'], $validated['destination']);
        $validated['ongkos_jasa_otomatis'] = $ongkosJasaOtomatis;


        // Update order
        $order->update($validated);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function cancel(Order $order, Request $request) // Tambahkan Request $request
    {
        // Logic untuk cancel pesanan
        if ($order->customer_id !== auth()->id() || !in_array($order->status, ['pending', 'accepted'])) {
            abort(403);
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancel_reason' => $request->reason ?? 'Dibatalkan oleh customer'
        ]);

        // Jika pesanan dibatalkan setelah diterima traveler, reset traveler_id
        if ($order->traveler_id && in_array($order->status, ['accepted', 'in_progress'])) {
            $order->update(['traveler_id' => null]);
        }

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function rate(Request $request, Order $order)
    {
        // Validasi authorization
        if ($order->customer_id !== auth()->id() || $order->status !== 'completed') {
            abort(403, 'Tidak dapat memberikan rating untuk pesanan ini');
        }

        // Validasi jika rating sudah ada
        if ($order->customer_rating) {
            return redirect()->back()->with('error', 'Rating sudah pernah diberikan');
        }

        // Validasi traveler harus ada
        if (!$order->traveler || $order->traveler->role !== 'traveler') {
            return redirect()->back()->with('error', 'Tidak dapat memberikan rating');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500'
        ]);

        // Update rating pada order
        $order->update([
            'customer_rating' => $request->rating,
            'customer_review' => $request->review
        ]);

        // Update rating traveler
        $order->traveler->updateRating();

        return redirect()->back()->with('success', 'Rating berhasil diberikan');
    }

    public function reorder(Order $order)
    {
        // Logic untuk duplicate pesanan
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.create_order', [
            'reorderData' => $order->only([
                'nama_barang',
                'kategori',
                'deskripsi',
                'budget',
                'destination',
                'link_produk',
                'catatan_khusus'
            ])
        ]);
    }

    public function invoice(Order $order)
    {
        // Logic untuk generate PDF invoice
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.invoice', compact('order'));
    }
}
