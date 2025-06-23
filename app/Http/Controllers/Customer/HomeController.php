<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama untuk Customer setelah login.
     */
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // VALIDASI: Ambil 4 pesanan aktif TERBARU milik user ini saja
        $myActiveOrders = $user->ordersAsCustomer()
                               ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                               ->latest()
                               ->take(4)
                               ->get();

        // Kirim data pesanan yang sudah difilter ke view
        return view('customer.home', compact('myActiveOrders'));
    }
}