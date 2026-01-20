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
            $this->info('Attempting to list files from Google Drive...');

            // Try to list the contents of the configured folder
            $files = Storage::disk('google')->files(); // This lists files in the root of the 'google' disk (which is already mapped to folder ID)

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
                $this->line('Hint: A 404 error often means the Folder ID is incorrect or the account doesnt have permission to access it.');
            }
            if (str_contains($e->getMessage(), 'invalid_grant')) {
                $this->line('Hint: invalid_grant usually means the Refresh Token is invalid, expired, or revoked.');
            }
        }
    }
}
