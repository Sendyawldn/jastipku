<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class HomeController extends Controller
{
    // Menampilkan halaman utama untuk Traveler setelah login
     public function index()
        {
            // Ambil 4 pesanan terbaru yang tersedia untuk diambil
            $availableOrders = Order::where('status', 'Menunggu Traveler')
                                    ->latest()
                                    ->take(4)
                                    ->get();

            // Kirim data pesanan ke view
            return view('traveler.home', compact('availableOrders'));
        }
}
