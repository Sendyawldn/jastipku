<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Query dasar untuk orders yang sudah selesai atau dibatalkan
        $query = Order::where('customer_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['traveler'])
            ->orderBy('updated_at', 'desc');

        // Apply filters jika ada
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // PERBAIKAN: Filter kategori yang lebih lengkap
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
                    $query->orderBy('budget', 'desc');
                    break;
                case 'lowest':
                    $query->orderBy('budget', 'asc');
                    break;
                default: // newest
                    $query->orderBy('updated_at', 'desc');
                    break;
            }
        }

        // Gunakan paginate() bukan get()
        $orders = $query->paginate(12)->appends($request->all());

        // Calculate statistics
        $allOrders = Order::where('customer_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->get();

        $stats = [
            'completed' => $allOrders->where('status', 'completed')->count(),
            'cancelled' => $allOrders->where('status', 'cancelled')->count(),
            'total_spent' => $allOrders->where('status', 'completed')->sum('total_pembayaran') ?: $allOrders->where('status', 'completed')->sum('budget'),
            'avg_spent' => $allOrders->where('status', 'completed')->count() > 0
                ? ($allOrders->where('status', 'completed')->sum('total_pembayaran') ?: $allOrders->where('status', 'completed')->sum('budget')) / $allOrders->where('status', 'completed')->count()
                : 0
        ];

        return view('customer.riwayat_transaksi', compact('orders', 'stats'));
    }
}
