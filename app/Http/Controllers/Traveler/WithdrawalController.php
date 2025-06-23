<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use App\Models\TravelerProfile;
use App\Models\User;

class WithdrawalController extends Controller
{
    // Method untuk menampilkan riwayat penarikan
    public function index()
    {
        $user = Auth::user();
        $currentBalance = $user->balance; // Ambil saldo dari kolom balance user
        $bankDetails = $user->travelerProfile;
        $withdrawals = $user->withdrawals()->latest()->get();

        return view('traveler.withdrawals.index', compact('currentBalance', 'bankDetails', 'withdrawals'));
    }

    // Method untuk memproses pengajuan penarikan
    public function store(Request $request)
    {
        $user = Auth::user();
        $travelerProfile = $user->travelerProfile;

        $request->validate([
            'amount' => 'required|numeric|min:50000', // Pastikan ini sesuai dengan minimum di UI
        ]);

        // Validasi detail bank traveler
        if (!$travelerProfile || empty($travelerProfile->bank_name) || empty($travelerProfile->bank_account_number) || empty($travelerProfile->bank_account_name)) {
            return back()->with('error', 'Harap lengkapi informasi bank Anda di profil sebelum mengajukan penarikan saldo.');
        }

        // Validasi saldo user
        if ($request->amount > $user->balance) {
            return back()->with('error', 'Saldo Anda tidak mencukupi untuk penarikan ini. Saldo tersedia: Rp ' . number_format($user->balance, 0, ',', '.'));
        }

        // LANGSUNG KURANGI SALDO DARI KOLOM 'balance' USER SAAT PENGAJUAN
        $user->deductBalance($request->amount);

        // Buat record permintaan penarikan dengan status pending
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending', // Status awal: pending
            'bank_name' => $travelerProfile->bank_name,
            'bank_account_number' => $travelerProfile->bank_account_number,
            'bank_account_name' => $travelerProfile->bank_account_name,
            'requested_at' => now(),
        ]);

        return redirect()->route('traveler.dashboard')->with('success', 'Permintaan penarikan saldo berhasil diajukan. Saldo Anda telah dikurangi dan menunggu persetujuan admin.');
    }
}
