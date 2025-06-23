<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Filter untuk pesanan
        $query = Order::with(['customer', 'traveler'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan pulau
        if ($request->filled('pulau')) {
            $kotaByPulau = $this->getKotaByPulau();
            if (isset($kotaByPulau[$request->pulau])) {
                $query->whereIn('destination', $kotaByPulau[$request->pulau]);
            }
        }

        // Filter berdasarkan destination
        if ($request->filled('destination')) {
            $query->where('destination', $request->destination);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Ambil pesanan dengan pagination
        $orders = $query->paginate(6);

        // Data untuk filter
        $kotaByPulau = $this->getKotaByPulau();
        $allDestinations = Order::distinct()->pluck('destination')->filter()->sort();

        // Daftar kategori
        $kategoriList = [
            'fashion' => 'Fashion',
            'skincare' => 'Skincare',
            'elektronik' => 'Elektronik',
            'makanan' => 'Makanan',
            'buku' => 'Buku',
            'beauty' => 'Beauty',
            'accessories' => 'Accessories',
            'toys' => 'Mainan',
            'sports' => 'Olahraga',
            'home' => 'Rumah Tangga'
        ];

        return view('welcome', compact('orders', 'kotaByPulau', 'allDestinations', 'kategoriList'));
    }

    public function loadMoreOrders(Request $request)
    {
        $query = Order::with(['customer']) // Cukup load customer
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc');

        // Terapkan filter yang sama
        if ($request->filled('pulau')) {
            $kotaByPulau = $this->getKotaByPulau();
            if (isset($kotaByPulau[$request->pulau])) {
                $query->whereIn('destination', $kotaByPulau[$request->pulau]);
            }
        }

        if ($request->filled('destination')) {
            $query->where('destination', $request->destination);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $page = $request->get('page', 2);
        $orders = $query->paginate(6, ['*'], 'page', $page);

        // Ubah data order menjadi format yang mudah digunakan oleh JavaScript
        $formattedOrders = array_map(function($order) {
            return [
                'id' => $order->id,
                'nama_barang' => $order->nama_barang,
                'deskripsi_short' => \Illuminate\Support\Str::limit($order->deskripsi, 80),
                'destination' => ucfirst($order->destination),
                'kategori' => ucfirst($order->kategori),
                'budget_formatted' => 'Rp ' . number_format($order->budget, 0, ',', '.'),
                'created_at_human' => $order->created_at->diffForHumans(),
                'customer_name' => $order->customer->name,
                'customer_avatar' => $order->customer->profile_photo_path
                    ? asset('storage/' . $order->customer->profile_photo_path)
                    : 'https://via.placeholder.com/30x30/764ba2/white?text=' . substr($order->customer->name, 0, 1),
                'detail_url' => route('orders.show_public', $order),
                'accept_url' => route('traveler.orders.accept', $order)
            ];
        }, $orders->items());

        return response()->json([
            'orders' => $formattedOrders,
            'hasMore' => $orders->hasMorePages()
        ]);
    }

    private function getKotaByPulau()
    {
        return [
            'jawa' => [
                'jakarta',
                'bandung',
                'surabaya',
                'yogyakarta',
                'semarang',
                'malang',
                'solo',
                'bogor',
                'depok',
                'tangerang',
                'bekasi',
                'cirebon',
                'purwokerto',
                'tegal',

            ],
            'sumatera' => [
                'medan',
                'palembang',
                'pekanbaru',
                'padang',
                'bandar lampung',
                'jambi',
                'bengkulu',
                'banda aceh',
                'batam',
                'dumai',
            ],
            'kalimantan' => [
                'banjarmasin',
                'pontianak',
                'samarinda',
                'balikpapan',
                'palangkaraya',
                'tarakan',
                'singkawang',
                'bontang',
            ],
            'sulawesi' => [
                'makassar',
                'manado',
                'palu',
                'kendari',
                'gorontalo',
                'pare-pare',
                'palopo',
                'bitung',

            ],
            'bali_ntt' => [
                'denpasar',
                'ubud',
                'sanur',
                'kuta',
                'kupang',
                'mataram',
                'sumbawa',
                'labuan bajo',
                'maumere',
            ],
            'papua_maluku' => [
                'jayapura',
                'merauke',
                'sorong',
                'ambon',
                'ternate',
                'manokwari',
                'timika',
            ]
        ];
    }

    public function getKotaByPulauAjax(Request $request)
    {
        $pulau = $request->get('pulau');
        $kotaByPulau = $this->getKotaByPulau();

        $kota = isset($kotaByPulau[$pulau]) ? $kotaByPulau[$pulau] : [];

        return response()->json($kota);
    }

    /**
     * BARU: Menampilkan halaman detail pesanan untuk publik.
     */
    public function showOrder(Order $order)
    {
        // Eager load data customer untuk ditampilkan
        $order->load('customer');

        // Hanya pesanan yang 'pending' yang seharusnya punya halaman detail publik,
        // namun kita akan menampilkannya dengan notice jika statusnya sudah berubah.
        return view('order_public_detail', compact('order'));
    }
}
