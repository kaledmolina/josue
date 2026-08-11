<?php

namespace App\Filament\Resources\FileResource\Pages\Concerns;

use App\Support\ImageUrl;
use Illuminate\Support\Facades\Storage;

trait HandlesFileFormData
{
    /**
     * Al editar, marca el toggle "usar enlace externo" si la imagen es una URL.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['is_external'] = ! empty($data['external_url']);

        return $data;
    }

    /**
     * Normaliza los datos según el origen elegido (archivo subido o URL externa).
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->normalizeFileData($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->normalizeFileData($data);
    }

    private function normalizeFileData(array $data): array
    {
        $useExternal = (bool) ($data['is_external'] ?? false);
        unset($data['is_external']);

        if ($useExternal) {
            // Imagen por URL: no hay archivo en disco.
            $data['external_url'] = ImageUrl::normalize($data['external_url'] ?? null);
            $data['path'] = null;
            $data['mime_type'] = 'image/url';
            $data['size'] = 0;

            if (blank($data['name'] ?? null)) {
                $filename = basename((string) parse_url($data['external_url'] ?? '', PHP_URL_PATH));
                $data['name'] = $filename ?: 'Imagen externa';
            }

            return $data;
        }

        // Archivo subido: no hay URL externa.
        $data['external_url'] = null;

        if (! empty($data['path'])) {
            $disk = $data['disk'] ?? 'google';

            if (blank($data['name'] ?? null)) {
                $data['name'] = basename($data['path']);
            }

            // Completamos mime_type y size automáticamente desde el almacenamiento.
            try {
                $data['mime_type'] = Storage::disk($disk)->mimeType($data['path']) ?: ($data['mime_type'] ?? 'image/*');
                $data['size'] = Storage::disk($disk)->size($data['path']);
            } catch (\Throwable $e) {
                $data['mime_type'] ??= 'image/*';
                $data['size'] ??= 0;
            }
        }

        return $data;
    }
}
