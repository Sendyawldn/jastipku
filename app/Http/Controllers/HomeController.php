<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // Redirect ke dashboard yang sesuai berdasarkan role
        if ($user->role === 'penitip') {
            return redirect()->route('customer.dashboard');
        } elseif ($user->role === 'traveler') {
            return redirect()->route('traveler.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Default redirect jika role tidak dikenali
        return redirect('/');
    }
}
