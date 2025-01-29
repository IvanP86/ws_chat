<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create database backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "backup2-" . now()->format('Y-m-d') . ".sql";
        if(!is_dir("storage/app/backUp")) {
            mkdir("storage/app/backUp", 0777, true);
        }
        $path = storage_path("app/backUp/{$filename}");
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD')
            . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE')
            . "  > " . $path;

        exec($command);
    }
}
