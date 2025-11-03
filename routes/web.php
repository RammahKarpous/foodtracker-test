<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('/dashboard');
});

Volt::route('/login', 'auth.login')->name('login');
// Registration disabled
// Volt::route('/register', 'auth.register')->name('register');

Route::middleware('auth')->group(function () {
    // Default redirect to products page
    Route::get('/dashboard', function () {
        return redirect('/producten');
    });
    
    Route::get('/producten', function () {
        return view('products');
    })->name('products');
    
    Route::get('/dagboek', function () {
        return view('diary');
    })->name('diary');
    
    Route::get('/overzicht', function () {
        return view('overview');
    })->name('overview');
    
    Route::get('/nutrition-limieten', function () {
        return view('nutrition-limits');
    })->name('nutrition-limits');
    
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
