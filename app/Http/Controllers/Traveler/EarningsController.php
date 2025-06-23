<?php
// p/app/Http/Controllers/Traveler/EarningsController.php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Withdrawal; // Pastikan model Withdrawal dipanggil
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class EarningsController extends Controller
{
    /**
     * Menampilkan halaman utama Penghasilan.
     */
    public function index()
    {
        $user = Auth::user();

        // Menghitung total penghasilan dari order yang selesai
        $totalEarnings = $user->ordersAsTraveler()->where('status', 'completed')->sum('ongkos_jasa') ?? 0;

        // Menghitung total dana yang sudah ditarik dari tabel riwayat penarikan
        $totalWithdrawn = Withdrawal::where('user_id', $user->id)->where('status', '!=', 'Rejected')->sum('amount');

        // Saldo tersedia adalah selisih antara total penghasilan dan total penarikan
        $availableBalance = $totalEarnings - $totalWithdrawn;

        $completedCount = $user->ordersAsTraveler()->where('status', 'completed')->count();
        $averageEarning = $completedCount > 0 ? $totalEarnings / $completedCount : 0;

        $stats = [
            'total' => $totalEarnings,
            'balance' => $availableBalance,
            'completed_count' => $completedCount,
            'average' => $averageEarning,
        ];

        // Mengambil 5 transaksi penghasilan terakhir
        $recentTransactions = $user->ordersAsTraveler()->where('status', 'completed')->latest('completed_at')->take(5)->get();

        return view('traveler.penghasilan', compact('stats', 'recentTransactions'));
    }

    /**
     * Memproses permintaan penarikan dana.
     */
    public function withdraw(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:50000']);

        $user = Auth::user();
        $travelerProfile = $user->travelerProfile;

        // Validasi rekening bank
        if (!$travelerProfile || !$travelerProfile->bank_name || !$travelerProfile->bank_account_number) {
            return Redirect::route('traveler.earnings.index')->with('error', 'Informasi rekening bank belum lengkap.');
        }

        // Hitung ulang saldo untuk keamanan
        $totalEarnings = $user->ordersAsTraveler()->where('status', 'completed')->sum('ongkos_jasa') ?? 0;
        $totalWithdrawn = Withdrawal::where('user_id', $user->id)->where('status', '!=', 'Rejected')->sum('amount');
        $availableBalance = $totalEarnings - $totalWithdrawn;

        // Validasi jumlah penarikan tidak melebihi saldo
        if ($request->input('amount') > $availableBalance) {
            throw ValidationException::withMessages(['amount' => 'Jumlah penarikan melebihi saldo yang tersedia.']);
        }

        // **LOGIKA BARU:** Membuat catatan baru di tabel `withdrawals`
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->input('amount'),
            'status' => 'Pending', // Status awal penarikan bisa diupdate oleh admin nanti
            'bank_name' => $travelerProfile->bank_name,
            'bank_account_name' => $travelerProfile->bank_account_name,
            'bank_account_number' => $travelerProfile->bank_account_number,
        ]);

        return Redirect::route('traveler.earnings.index')->with('success', 'Permintaan penarikan dana berhasil diajukan dan akan segera diproses.');
    }

    /**
     * Menampilkan halaman riwayat penarikan dana.
     */
    public function history()
    {
        // Mengambil semua data dari tabel withdrawals untuk user yang login
        $withdrawals = Withdrawal::where('user_id', Auth::id())
                                 ->latest()
                                 ->paginate(15);

        // Mengirim data ke view riwayat penarikan
        return view('traveler.earnings_history', compact('withdrawals'));
    }
}