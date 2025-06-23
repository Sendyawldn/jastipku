<?php
// filepath: c:\laragon\www\jastipku\app\Http\Controllers\Traveler\ActiveOrderController.php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeOrders = Order::where('traveler_id', $user->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->with(['customer'])
            ->orderBy('deadline', 'asc')
            ->get();

        return view('traveler.active_order', compact('activeOrders'));
    }

    public function accept(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak tersedia');
        }

        $order->update([
            'traveler_id' => auth()->id(),
            'status' => 'accepted',
            'accepted_at' => now()
        ]);

        return redirect()->route('traveler.active_orders.index')
            ->with('success', 'Pesanan berhasil diambil!');
    }

    public function start(Order $order)
    {
        if ($order->traveler_id !== auth()->id() || $order->status !== 'accepted') {
            abort(403, 'Tidak dapat memulai pesanan ini');
        }

        $order->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);

        return redirect()->back()->with('success', 'Pesanan dimulai!');
    }

    public function complete(Request $request, Order $order)
    {
        if ($order->traveler_id !== auth()->id() || $order->status !== 'in_progress') {
            abort(403, 'Tidak dapat menyelesaikan pesanan ini');
        }

        $request->validate([
            'total_belanja' => 'required|numeric|min:0',
            'ongkos_jasa' => 'required|numeric|min:0',
        ]);

        $totalPembayaran = $request->total_belanja + $request->ongkos_jasa;

        // $buktiBelanjaPath = null;
        // if ($request->hasFile('bukti_belanja')) {
        //     $buktiBelanjaPath = $request->file('bukti_belanja')->store('bukti-belanja', 'public');
        // }

        $order->update([
            'status' => 'completed',
            'total_belanja' => $request->total_belanja,
            'ongkos_jasa' => $request->ongkos_jasa,
            'total_pembayaran' => $totalPembayaran,
            'completed_at' => now(),
            'payment_status' => 'paid',
        ]);

        if ($order->traveler) {
            $order->traveler->updateRating();
        }

        return redirect()->route('traveler.active_orders.index')
            ->with('success', 'Pesanan berhasil diselesaikan! Penghasilan Rp ' . number_format($request->ongkos_jasa, 0, ',', '.') . ' telah ditambahkan ke saldo Anda.');
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->traveler_id !== auth()->id() || !in_array($order->status, ['accepted', 'in_progress'])) {
            abort(403, 'Tidak dapat membatalkan pesanan ini');
        }

        $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        $order->update([
            'status' => 'pending', // Kembali ke pending agar bisa diambil traveler lain
            'cancelled_at' => now(),
            'cancel_reason' => $request->cancel_reason,
            'traveler_id' => null, // Reset traveler
        ]);

        return redirect()->route('traveler.dashboard')
            ->with('success', 'Pesanan berhasil dibatalkan');
    }
}
