<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // UPDATE: Auto-update rating jika belum ada atau perlu refresh
        if ($user->isTraveler() && (is_null($user->rating) || $user->updated_at->lt(now()->subHour()))) {
            $user->updateRating();
        }

        // Stats untuk dashboard
        $stats = [
            'baru' => Order::where('status', 'pending')->count(),
            'proses' => Order::where('traveler_id', $user->id)
                ->whereIn('status', ['accepted', 'in_progress'])
                ->count(),
            'selesai' => Order::where('traveler_id', $user->id)
                ->where('status', 'completed')
                ->count(),
        ];

        // Available orders (pesanan yang bisa diambil)
        $availableOrders = Order::where('status', 'pending')
            ->with(['customer'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('traveler.dashboard', compact('stats', 'availableOrders'));
    }
}
