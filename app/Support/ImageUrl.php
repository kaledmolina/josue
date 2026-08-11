<?php

namespace App\Support;

class ImageUrl
{
    /**
     * Convierte enlaces compartidos de Google Drive en URLs directas de imagen.
     *
     * Google Drive no permite incrustar la página del visor (/file/d/.../view, HTML)
     * ni el endpoint uc (lo bloquea el navegador con ORB), por eso se transforma
     * al enlace directo de imagen: https://lh3.googleusercontent.com/d/{id}
     */
    public static function normalize(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);

        // https://drive.google.com/file/d/{id}/view?usp=sharing
        if (preg_match('#drive\.google\.com/file/d/([A-Za-z0-9_-]+)#', $url, $matches)) {
            return self::directUrl($matches[1]);
        }

        // https://drive.google.com/open?id={id}
        if (preg_match('#drive\.google\.com/open\?.*\bid=([A-Za-z0-9_-]+)#', $url, $matches)) {
            return self::directUrl($matches[1]);
        }

        // https://drive.google.com/uc?id={id}&export=download -> siempre export=view para incrustar
        if (preg_match('#drive\.google\.com/uc\?.*\bid=([A-Za-z0-9_-]+)#', $url, $matches)) {
            return self::directUrl($matches[1]);
        }

        return $url;
    }

    private static function directUrl(string $id): string
    {
        return 'https://lh3.googleusercontent.com/d/'.$id;
    }
}
