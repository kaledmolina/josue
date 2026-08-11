<?php

use App\Livewire\Acerca;
use App\Livewire\AlbumPhotos;
use App\Livewire\Contacto;
use App\Livewire\Fotografias;
use App\Livewire\Home;
use App\Livewire\Proyectos;
use App\Livewire\Videos;
use App\Models\Album;
use App\Models\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', Home::class)->name('home');
Route::get('/fotografias', Fotografias::class)->name('fotografias');
Route::get('/albums/{albumId}', AlbumPhotos::class)->name('album.photos');
Route::get('/videos', Videos::class);
Route::get('/proyectos', Proyectos::class);
Route::get('/contacto', Contacto::class);
Route::get('/acerca', Acerca::class);
Route::get('/preview-file/{file}', function ($fileId) {
    $file = \App\Models\File::findOrFail($fileId);

    // Si la imagen fue agregada por URL externa, redirigimos directamente a esa URL.
    if ($external = \App\Support\ImageUrl::normalize($file->external_url)) {
        return redirect()->away($external, 302, ['Cache-Control' => 'public, max-age=31536000, immutable']);
    }

    try {
        $fileContents = Storage::disk('google')->get($file->path);

        return response($fileContents)
            ->header('Content-Type', $file->mime_type)
            ->header('Content-Disposition', 'inline; filename="'.$file->name.'"');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Google Drive Error for file '.$fileId.': '.$e->getMessage());
        abort(404);
    }
})->name('file.preview');

Route::get('/album/{album}/cover', function (Album $album) {
    // Si el álbum tiene portada por URL externa, redirigimos directamente a esa URL.
    if ($cover = \App\Support\ImageUrl::normalize($album->cover_image_url)) {
        return redirect()->away($cover, 302, ['Cache-Control' => 'public, max-age=86400']);
    }

    try {
        // Portada determinística: la foto más reciente del álbum (consistente y cacheable,
        // evita que el navegador regrese a una portada distinta o que Drive bloquee la petición).
        $coverFile = $album->files()->latest()->first();

        if (! $coverFile) {
            abort(404);
        }

        // Si la portada es una imagen por URL externa, redirigimos a su enlace directo.
        if ($coverFile->isExternal()) {
            return redirect()->away(\App\Support\ImageUrl::normalize($coverFile->external_url), 302, ['Cache-Control' => 'public, max-age=86400']);
        }

        $fileContents = Storage::disk($coverFile->disk)->get($coverFile->path);

        return response($fileContents)
            ->header('Content-Type', $coverFile->mime_type)
            ->header('Content-Disposition', 'inline; filename="'.$coverFile->name.'"')
            ->header('Cache-Control', 'public, max-age=31536000');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Album Cover Error: '.$e->getMessage());
        abort(404);
    }
})->name('album.cover');
