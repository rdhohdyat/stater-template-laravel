<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

class BackupController extends Controller
{
    /**
     * Show the backup management page.
     */
    public function index()
    {
        return view('backups.index');
    }

    /**
     * Run the backup process.
     */
    public function run()
    {
        try {
            // Run only the database backup to keep it fast and light
            $exitCode = Artisan::call('backup:run --only-db --disable-notifications');
            $output = Artisan::output();

            if ($exitCode !== 0) {
                return back()->with('error', 'Gagal membuat backup secara otomatis. Output: ' . substr($output, 0, 100));
            }

            return back()->with('success', 'Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'System Error: ' . $e->getMessage());
        }
    }

    /**
     * Download the latest backup file.
     */
    public function download()
    {
        try {
            $disks = config('backup.backup.destination.disks', ['local']);
            $diskName = $disks[0];
            $disk = Storage::disk($diskName);
            $backupName = config('backup.backup.name', 'laravel-backup');

            // Get all files from the backup directory
            $files = $disk->allFiles($backupName);

            // Filter for only .zip files
            $zipFiles = array_filter($files, function ($file) {
                return str_ends_with($file, '.zip');
            });

            if (empty($zipFiles)) {
                return back()->with('error', 'Tidak ada file backup (.zip) yang ditemukan. Pastikan Anda sudah menjalankan backup setidaknya sekali.');
            }

            // Sort by last modified to get the newest
            usort($zipFiles, function ($a, $b) use ($disk) {
                return $disk->lastModified($b) - $disk->lastModified($a);
            });

            $latestFile = reset($zipFiles);

            if (!$disk->exists($latestFile)) {
                return back()->with('error', 'File backup tidak ditemukan di penyimpanan.');
            }

            // Provide a nice filename for the download
            $filename = basename($latestFile);

            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            return $disk->download($latestFile, $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses unduhan: ' . $e->getMessage());
        }
    }
}
