<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Home;
use App\Livewire\Videos;


Route::get('/', Home::class)->name('home');
Route::get('/videos', Videos::class);