<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah peran user yang login tidak sama dengan peran yang diminta oleh rute
        if ($request->user()->role !== $role) {

            // Jika tidak sesuai, arahkan ke dashboard mereka masing-masing
            if ($request->user()->role === 'penitip') {
                return redirect()->route('customer.dashboard');
            } elseif ($request->user()->role === 'traveler') {
                return redirect()->route('traveler.dashboard');
            }

            // Jika ada peran lain, arahkan ke halaman utama
            return redirect('/');
        }

        // Jika peran sudah sesuai, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}