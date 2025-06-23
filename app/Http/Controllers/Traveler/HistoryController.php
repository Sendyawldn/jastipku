<?php
// p/app/Http/Controllers/Traveler/HistoryController.php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Refresh rating jika diperlukan
        if ($user->isTraveler()) {
            $user->updateRating();
        }

        // Query untuk orders yang sudah selesai atau dibatalkan oleh traveler ini
        $query = Order::where('traveler_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['customer'])
            ->orderBy('updated_at', 'desc');

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category) {
            $validCategories = [
                'fashion',
                'skincare',
                'elektronik',
                'makanan',
                'buku',
                'beauty',
                'accessories',
                'toys',
                'sports',
                'home',
                'lainnya'
            ];

            if (in_array($request->category, $validCategories)) {
                $query->where('kategori', $request->category);
            }
        }

        if ($request->has('search') && $request->search) {
            $query->where('nama_barang', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('month') && $request->month) {
            $query->whereRaw('DATE_FORMAT(updated_at, "%Y-%m") = ?', [$request->month]);
        }

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('updated_at', 'asc');
                    break;
                case 'highest':
                    $query->orderBy('ongkos_jasa', 'desc');
                    break;
                case 'lowest':
                    $query->orderBy('ongkos_jasa', 'asc');
                    break;
                default: // newest
                    $query->orderBy('updated_at', 'desc');
                    break;
            }
        }

        $orders = $query->paginate(12)->appends($request->all());

        return view('traveler.traveller_order_history', compact('orders'));
    }

    /**
     * Menampilkan halaman invoice untuk traveler.
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function invoice(Order $order)
    {
        // Pastikan traveler yang login adalah yang menangani order ini
        if ($order->traveler_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        // Pastikan order sudah selesai
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Invoice hanya tersedia untuk pesanan yang telah selesai.');
        }

        return view('traveler.invoice', compact('order'));
    }
}