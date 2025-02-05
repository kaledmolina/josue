<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    protected $client;
    protected $service;
    protected $folderId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->refreshToken(config('services.google.refresh_token'));
        
        $this->service = new Drive($this->client);
        $this->folderId = config('services.google.folder_id');
    }

    public function uploadFile(UploadedFile $file, string $fileName)
    {
        $accessToken = $this->getAccessToken();
        
        $response = Http::withToken($accessToken)
            ->attach('data', $file->get(), $fileName)
            ->post('https://www.googleapis.com/upload/drive/v3/files', [
                'name' => $fileName,
                'parents' => [$this->folderId]
            ]);

        if ($response->successful()) {
            return $response->json()['id'];
        }

        throw new \Exception('Error al subir el archivo: '.$response->body());
    }

    public function getFileUrl(string $fileId)
    {
        return "https://drive.google.com/uc?export=view&id={$fileId}";
    }

    public function downloadFile(string $fileId, string $fileName)
    {
        $accessToken = $this->getAccessToken();
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$accessToken,
        ])->get("https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media");

        if ($response->successful()) {
            $tempPath = tempnam(sys_get_temp_dir(), 'gdrive');
            file_put_contents($tempPath, $response->body());
            
            return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
        }

        throw new \Exception('Error al descargar el archivo: '.$response->body());
    }

    protected function getAccessToken()
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => config('services.google.refresh_token'),
            'grant_type' => 'refresh_token',
        ]);

        return $response->json()['access_token'];
    }
}