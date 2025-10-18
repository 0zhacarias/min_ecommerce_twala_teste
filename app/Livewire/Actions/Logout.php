<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        $carrinho = session('carrinho', []);
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
        session(['carrinho' => $carrinho]);
        return redirect('/');
    }
}
