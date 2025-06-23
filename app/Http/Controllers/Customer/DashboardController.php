<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik untuk customer
        $stats = [
            'proses' => $user->ordersAsCustomer()
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            'selesai' => $user->ordersAsCustomer()
                ->where('status', 'completed')
                ->count(),
            'pengiriman' => $user->ordersAsCustomer()
                ->where('status', 'in_progress')
                ->count(),
        ];

        // Pesanan terbaru
        $recentOrders = $user->ordersAsCustomer()
            ->with('traveler')
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders', 'user'));
    }
}
