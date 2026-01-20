<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Home;
use App\Livewire\Videos;
use App\Livewire\Fotografias;
use App\Livewire\AlbumPhotos;
use App\Livewire\Proyectos;
use App\Livewire\Contacto;
use App\Livewire\Acerca;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Album;


Route::get('/', Home::class)->name('home');
Route::get('/fotografias', Fotografias::class)->name('fotografias');
Route::get('/albums/{albumId}', AlbumPhotos::class)->name('album.photos');
Route::get('/videos', Videos::class);
Route::get('/proyectos', Proyectos::class);
Route::get('/contacto', Contacto::class);
Route::get('/acerca', Acerca::class);
Route::get('/preview-file/{file}', function ($fileId) {
    $file = \App\Models\File::findOrFail($fileId);

    try {
        $fileContents = Storage::disk('google')->get($file->path);

        return response($fileContents)
            ->header('Content-Type', $file->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $file->name . '"');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Google Drive Error for file ' . $fileId . ': ' . $e->getMessage());
        abort(404);
    }
})->name('file.preview');

Route::get('/album/{album}/cover', function (Album $album) {
    try {
        $fileContents = Storage::disk($album->disk)->get($album->path);

        return response($fileContents)
            ->header('Content-Type', 'image/jpeg') // Ajusta según tu tipo de imagen
            ->header('Content-Disposition', 'inline; filename="cover.jpg"')
            ->header('Cache-Control', 'public, max-age=31536000');
    } catch (\Exception $e) {
        abort(404);
    }
})->name('album.cover');