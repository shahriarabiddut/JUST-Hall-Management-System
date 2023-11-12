<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create copy of mysql dump for existing database.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $backupFileName = 'backup_' . date('Y-m-d_His') . '.sql';
        $databaseName = config('database.connections.mysql.database');

        // Create backup folder and set permission if not exist.
        $storageAt = storage_path() . "/app/backup/";
        if (!File::exists($storageAt)) {
            File::makeDirectory($storageAt, 0755, true, true);
        }
        // Command for Backup Database.
        $command = "mysqldump -u " . config('database.connections.mysql.username') .
            " -p" . config('database.connections.mysql.password') .
            " " . $databaseName . " > " . $storageAt . $backupFileName;

        exec($command);

        $this->info('Database backup created successfully: ' . $backupFileName);
    }
}
