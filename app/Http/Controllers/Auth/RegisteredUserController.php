<?php
// p/app/Http/Controllers/Auth/RegisteredUserController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TravelerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string'],
            'role' => ['required', 'string', 'in:penitip,traveler'],
            // Validasi untuk traveler
            'nik' => ['required_if:role,traveler', 'nullable', 'string', 'digits:16', 'unique:traveler_profiles,nik'],
            'id_card' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        // Create traveler profile if needed
        if ($user->role === 'traveler') {
            $idCardPath = null;
            if ($request->hasFile('id_card')) {
                $idCardPath = $request->file('id_card')->store('id_cards', 'public');
            }

            TravelerProfile::create([
                'user_id' => $user->id,
                'nik' => $request->nik, // Simpan NIK
                'id_card_path' => $idCardPath,
                'travel_schedule' => $request->travel_schedule,
                'travel_purpose' => $request->travel_purpose,
                'verification_status' => 'pending', // Default ke pending
            ]);

            // Jangan langsung login traveler, arahkan ke halaman informasi menunggu verifikasi
            return redirect()->route('login')->with('status', 'Pendaftaran traveler Anda berhasil! Silakan tunggu konfirmasi dari admin.');
        }

        event(new Registered($user));
        Auth::login($user); // Jika penitip, langsung login

        // Redirect based on role (hanya untuk penitip yang langsung login)
        if ($user->role === 'penitip') {
            return redirect()->route('customer.dashboard');
        } else {
            // Ini seharusnya tidak terpanggil untuk traveler karena sudah return di atas
            return redirect()->route('traveler.dashboard');
        }
    }
}