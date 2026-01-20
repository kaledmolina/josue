<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Exception;

class TestGoogleDriveConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drive:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the connection to Google Drive and list files in the root folder.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Google Drive Connection...');

        $config = config('filesystems.disks.google');
        $this->table(
            ['Config Key', 'Value'],
            [
                ['Client ID', substr($config['clientId'] ?? 'MISSING', 0, 10) . '...'],
                ['Client Secret', substr($config['clientSecret'] ?? 'MISSING', 0, 5) . '...'],
                ['Refresh Token', substr($config['refreshToken'] ?? 'MISSING', 0, 10) . '...'],
                ['Folder ID', $config['folder'] ?? 'MISSING'],
            ]
        );

        try {
            // Test 1: Check Auth
            $this->info('Step 1: Testing Authentication (Fetching Access Token)...');
            $client = new \Google\Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $token = $client->fetchAccessTokenWithRefreshToken($config['refreshToken']);

            if (isset($token['error'])) {
                $this->error('Authentication Failed: ' . json_encode($token));
                $this->line('Hint: Your Refresh Token might be expired or invalid.');
                return;
            }

            $this->success('Authentication Successful! Access Token generated.');

            // Test 2: List Files
            $this->info('Step 2: Listing Files from Folder: ' . ($config['folder'] ?? 'N/A'));

            // Re-use standard storage to test the full integration
            $files = Storage::disk('google')->files();

            if (empty($files)) {
                $this->warn('Connection successful, but no files were found in the configured folder.');
            } else {
                $this->success('Connection successful! Found ' . count($files) . ' files.');

                // List first 5 files
                $headers = ['Filename'];
                $data = [];
                foreach (array_slice($files, 0, 5) as $file) {
                    $data[] = [$file];
                }
                $this->table($headers, $data);
            }

        } catch (Exception $e) {
            $this->error('Connection Failed!');
            $this->error('Error Message: ' . $e->getMessage());

            if (str_contains($e->getMessage(), '404')) {
                $this->line('Hint: A 404 error often means the Folder ID is incorrect ("apidrive" is NOT a valid ID).');
            }
        }
    }
}
