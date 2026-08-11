<?php

namespace App\Filament\Resources\AlbumResource\Pages\Concerns;

use App\Support\ImageUrl;

trait HandlesAlbumFormData
{
    /**
     * Al editar, marca el toggle "usar enlace externo" si la portada es una URL.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['is_external_cover'] = ! empty($data['cover_image_url']);

        return $data;
    }

    /**
     * Normaliza los datos según el origen de la portada (archivo subido o URL externa).
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->normalizeAlbumData($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->normalizeAlbumData($data);
    }

    private function normalizeAlbumData(array $data): array
    {
        $useExternal = (bool) ($data['is_external_cover'] ?? false);
        unset($data['is_external_cover']);

        if ($useExternal) {
            // Portada por URL: no hay archivo en disco.
            $data['cover_image_url'] = ImageUrl::normalize($data['cover_image_url'] ?? null);
            $data['path'] = null;

            return $data;
        }

        // Portada subida: no hay URL externa.
        $data['cover_image_url'] = null;

        return $data;
    }
}
