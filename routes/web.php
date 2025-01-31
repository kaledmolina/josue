<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Home;
use App\Livewire\Videos;
use App\Livewire\Fotografias;
use App\Livewire\Proyectos;
use App\Livewire\Contacto;
use App\Livewire\Acerca;


Route::get('/', Home::class)->name('home');
Route::get('/fotografias', Fotografias::class);
Route::get('/videos', Videos::class);
Route::get('/proyectos', Proyectos::class);
Route::get('/contacto', Contacto::class);
Route::get('/acerca', Acerca::class);