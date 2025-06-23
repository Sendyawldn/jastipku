<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // UPDATE: Refresh rating untuk traveler
        if ($user->isTraveler()) {
            $user->updateRating();
        }

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'bio' => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // PERBAIKAN: 'profile_photo'

            // Traveler specific fields
            'travel_schedule' => ['nullable', 'string'],
            'travel_purpose' => ['nullable', 'string'],
            'available_for_orders' => ['nullable', 'boolean'],
            'bank_name' => ['nullable', 'string'],
            'bank_account_number' => ['nullable', 'string'],
            'bank_account_name' => ['nullable', 'string'],
        ]);

        $user = Auth::user();

        // PERBAIKAN: Handle profile photo upload dengan nama field yang konsisten
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Simpan foto baru dan update path di database
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');

            // PERBAIKAN: Set ke field database yang benar
            $validated['profile_photo_path'] = $photoPath;
        }

        // PERBAIKAN: Remove profile_photo from validated data karena ini bukan field database
        unset($validated['profile_photo']);

        // Update user basic info
        $user->fill($validated);

        // Jika email diubah, hapus verifikasi email sebelumnya
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Handle traveler profile jika user adalah traveler
        if ($user->role === 'traveler') {
            $travelerData = [
                'travel_schedule' => $validated['travel_schedule'] ?? null,
                'travel_purpose' => $validated['travel_purpose'] ?? null,
                'available_for_orders' => $request->has('available_for_orders'),
                'bank_name' => $validated['bank_name'] ?? null,
                'bank_account_number' => $validated['bank_account_number'] ?? null,
                'bank_account_name' => $validated['bank_account_name'] ?? null,
            ];

            // Create or update traveler profile
            $user->travelerProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $travelerData
            );
        }

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto profil jika ada
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
