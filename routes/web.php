<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Home;
use App\Livewire\Videos;


Route::get('/', Home::class);
Route::get('/videos', Videos::class);