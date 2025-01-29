<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteDatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:del-db-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all backup\'s from storage/app/backUp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = storage_path('app/backUp');

        if (!is_dir($directory)) {
            die("Указанная папка не существует.");
        }

        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                    if (unlink($filePath)) {
                        echo "Файл $file успешно удален.\n";
                    } else {
                        echo "Не удалось удалить файл $file.\n";
                    }
                }
            }
            closedir($handle);
        } else {
            echo "Не удалось открыть папку.";
        }
    }
}
